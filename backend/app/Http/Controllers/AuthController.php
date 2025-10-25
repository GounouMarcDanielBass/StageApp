<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Encadrant;
use PragmaRX\Google2FA\Google2FA;
use Carbon\Carbon;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'two_factor_code' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check for account lockout
        if ($user->locked_until && Carbon::now()->lessThan($user->locked_until)) {
            return response()->json(['error' => 'Account locked. Please try again after ' . $user->locked_until->diffForHumans(null, true) . '.'], 403);
        }

        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            // Increment failed attempts
            $user->increment('failed_attempts');

            // Lock account if failed attempts exceed threshold (e.g., 5 attempts)
            if ($user->failed_attempts >= 5) {
                $user->locked_until = Carbon::now()->addMinutes(30); // Lock for 30 minutes
                $user->failed_attempts = 0; // Reset attempts after locking
                $user->save();
                return response()->json(['error' => 'Too many failed login attempts. Account locked for 30 minutes.'], 403);
            }
            $user->save();
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Reset failed attempts on successful login
        $user->failed_attempts = 0;
        $user->locked_until = null;
        $user->save();

        // Check for 2FA
        if ($user->google2fa_enabled) {
            if (!$request->two_factor_code) {
                return response()->json(['message' => 'Two-factor authentication required.', 'two_factor_required' => true], 401);
            }

            $google2fa = new Google2FA();
            if (!$google2fa->verifyKey($user->google2fa_secret, $request->two_factor_code)) {
                return response()->json(['error' => 'Invalid two-factor code.'], 401);
            }
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request, $role)
    {
        // Manually merge first_name and last_name into a single 'name' field for validation
        $request->merge(['name' => $request->input('first_name') . ' ' . $request->input('last_name')]);

        $baseRules = [
            'name' => 'required|string|between:2,200',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ];

        $roleRules = [];
        switch($role) {
            case 'etudiant':
                $roleRules = [
                    'student_id' => 'required|string|unique:etudiants',
                    'formation' => 'required|string',
                ];
                break;
            case 'entreprise':
                $roleRules = [
                    'company_name' => 'required|string',
                    'siret' => 'required|string|unique:entreprises',
                ];
                break;
            case 'encadrant':
                $roleRules = [
                    'department' => 'required|string',
                    'speciality' => 'required|string',
                ];
                break;
            case 'admin':
                // No extra fields for admin
                break;
            default:
                return response()->json(['error' => 'Type de compte invalide'], 400);
        }

        $validator = Validator::make($request->all(), array_merge($baseRules, $roleRules));

        if($validator->fails()){
            // Return errors in a format the frontend can parse
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Proceed with registration based on role
        switch($role) {
            case 'etudiant':
                return $this->registerEtudiant($request);
            case 'entreprise':
                return $this->registerEntreprise($request);
            case 'encadrant':
                return $this->registerEncadrant($request);
            case 'admin':
                return $this->registerAdmin($request);
        }
    }

    public function registerEtudiant(Request $request)
    {
        // Validation is now handled in the main register method, we can proceed with creation
        DB::beginTransaction();
        try {
            $role = Role::where('name', 'etudiant')->firstOrFail();
             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'role_id' => $role->id
             ]);

            Etudiant::create([
                'user_id' => $user->id,
                'student_id' => $request->student_id,
                'formation' => $request->formation
            ]);

            DB::commit();

            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de l\'inscription', 'details' => $e->getMessage()], 500);
        }
    }

    public function registerEntreprise(Request $request)
    {
        // Validation is now handled in the main register method
        DB::beginTransaction();
        try {
            $role = Role::where('name', 'entreprise')->firstOrFail();
             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'role_id' => $role->id
             ]);

            Entreprise::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'siret' => $request->siret
            ]);

            DB::commit();

            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de l\'inscription', 'details' => $e->getMessage()], 500);
        }
    }

    public function registerEncadrant(Request $request)
    {
        // Validation is now handled in the main register method
        DB::beginTransaction();
        try {
            $role = Role::where('name', 'encadrant')->firstOrFail();
             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'role_id' => $role->id
             ]);

            Encadrant::create([
                'user_id' => $user->id,
                'department' => $request->department,
                'speciality' => $request->speciality
            ]);

            DB::commit();

            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de l\'inscription', 'details' => $e->getMessage()], 500);
        }
    }

    public function registerAdmin(Request $request)
    {
        // Validation is now handled in the main register method
        DB::beginTransaction();
        try {
            $role = Role::where('name', 'admin')->firstOrFail();
             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'role_id' => $role->id
             ]);

            DB::commit();

            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Erreur lors de l\'inscription', 'details' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh(JWTAuth::getToken()));
    }

    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    public function user()
    {
        return response()->json(JWTAuth::user());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => JWTAuth::user()
        ]);
    }

    public function generate2faSecret(Google2FA $google2fa)
    {
        $user = JWTAuth::user();
        $user->google2fa_secret = $google2fa->generateSecretKey();
        $user->save();

        $qrCodeUrl = $google2fa->getQrCodeUrl(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        return response()->json([
            'secret' => $user->google2fa_secret,
            'qr_code_url' => $qrCodeUrl
        ]);
    }

    public function enable2fa(Request $request, Google2FA $google2fa)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = JWTAuth::user();

        if ($user->google2fa_secret !== $request->secret) {
            return response()->json(['error' => 'Invalid secret.'], 400);
        }

        if (!$google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            return response()->json(['error' => 'Invalid 2FA code.'], 400);
        }

        $user->google2fa_enabled = true;
        $user->save();

        return response()->json(['message' => 'Two-factor authentication enabled successfully.']);
    }

    public function disable2fa(Request $request, Google2FA $google2fa)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = JWTAuth::user();

        if (!$google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            return response()->json(['error' => 'Invalid 2FA code.'], 400);
        }

        $user->google2fa_enabled = false;
        $user->google2fa_secret = null;
        $user->save();

        return response()->json(['message' => 'Two-factor authentication disabled successfully.']);
    }

    public function verify2fa(Request $request, Google2FA $google2fa)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = JWTAuth::user();

        if (!$user->google2fa_enabled || !$user->google2fa_secret) {
            return response()->json(['error' => 'Two-factor authentication is not enabled for this user.'], 400);
        }

        if (!$google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            return response()->json(['error' => 'Invalid two-factor code.'], 401);
        }

        return response()->json(['message' => 'Two-factor code verified successfully.']);
    }
}
