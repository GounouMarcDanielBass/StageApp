<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Offer;
use App\Models\Application;
use App\Models\Stage;
use App\Models\Evaluation;
use App\Models\Document;
use App\Models\Notification;
use App\Models\Message;
use Carbon\Carbon;

class CameroonDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create Roles with English names
        $roleAdmin = Role::firstOrCreate(['name' => 'admin'], ['description' => 'System Administrator']);
        $roleStudent = Role::firstOrCreate(['name' => 'student'], ['description' => 'Student User']);
        $roleCompany = Role::firstOrCreate(['name' => 'company'], ['description' => 'Company Representative']);
        $roleSupervisor = Role::firstOrCreate(['name' => 'supervisor'], ['description' => 'Academic Supervisor']);

        // Create Admin User
        $admin = User::updateOrCreate([
            'email' => 'admin@iuc.cm',
        ], [
            'name' => 'Admin IUC',
            'password' => Hash::make('password'),
            'role_id' => $roleAdmin->id,
        ]);

        // Create Supervisor Users
        $supervisor1 = User::updateOrCreate([
            'email' => 'prof.ngando@iuc.cm',
        ], [
            'name' => 'Professeur Ngando',
            'password' => Hash::make('password'),
            'role_id' => $roleSupervisor->id,
        ]);
        Supervisor::updateOrCreate([
            'user_id' => $supervisor1->id,
        ], [
            'department' => 'Computer Science Department',
            'specialization' => 'Artificial Intelligence',
            'academic_title' => 'Professor',
            'phone' => '+237 699 123 456',
            'office_location' => 'Building A, Room 101',
            'bio' => 'Expert in AI and Machine Learning with 15+ years experience',
            'is_available_for_supervision' => true,
            'max_students' => 8,
        ]);

        $supervisor2 = User::updateOrCreate([
            'email' => 'dr.kamga@iuc.cm',
        ], [
            'name' => 'Dr. Kamga Marie',
            'password' => Hash::make('password'),
            'role_id' => $roleSupervisor->id,
        ]);
        Supervisor::updateOrCreate([
            'user_id' => $supervisor2->id,
        ], [
            'department' => 'Computer Science Department',
            'specialization' => 'Software Engineering',
            'academic_title' => 'Associate Professor',
            'phone' => '+237 677 987 654',
            'office_location' => 'Building B, Room 205',
            'bio' => 'Specialist in software development methodologies and project management',
            'is_available_for_supervision' => true,
            'max_students' => 6,
        ]);

        // Create Company Users and Companies
        $companyUser1 = User::updateOrCreate([
            'email' => 'hr@mtn.cm',
        ], [
            'name' => 'MTN Cameroon HR',
            'password' => Hash::make('password'),
            'role_id' => $roleCompany->id,
        ]);
        $mtnCompany = Company::updateOrCreate([
            'user_id' => $companyUser1->id,
        ], [
            'company_name' => 'MTN Cameroon',
            'registration_number' => 'RC/YAE/2024/B/1234',
            'description' => 'Leading telecommunications company in Cameroon providing mobile, internet and digital services',
            'industry' => 'Telecommunications',
            'website' => 'https://www.mtn.cm',
            'phone' => '+237 699 100 100',
            'address' => 'MTN Headquarters, Boulevard du 20 Mai',
            'city' => 'Yaoundé',
            'postal_code' => 'BP 1500',
            'country' => 'Cameroon',
            'contact_person' => 'HR Manager',
            'contact_email' => 'hr@mtn.cm',
            'contact_phone' => '+237 699 100 200',
            'company_size' => 'Large',
            'founded_year' => 1998,
        ]);

        $companyUser2 = User::updateOrCreate([
            'email' => 'recrutement@orange.cm',
        ], [
            'name' => 'Orange Cameroun HR',
            'password' => Hash::make('password'),
            'role_id' => $roleCompany->id,
        ]);
        $orangeCompany = Company::updateOrCreate([
            'user_id' => $companyUser2->id,
        ], [
            'company_name' => 'Orange Cameroun',
            'registration_number' => 'RC/DLA/2024/B/5678',
            'description' => 'Major telecommunications operator offering mobile, internet and multimedia services',
            'industry' => 'Telecommunications',
            'website' => 'https://www.orange.cm',
            'phone' => '+237 699 200 200',
            'address' => 'Orange Headquarters, Boulevard de la Liberté',
            'city' => 'Douala',
            'postal_code' => 'BP 2500',
            'country' => 'Cameroon',
            'contact_person' => 'Talent Acquisition Manager',
            'contact_email' => 'recrutement@orange.cm',
            'contact_phone' => '+237 699 200 300',
            'company_size' => 'Large',
            'founded_year' => 2000,
        ]);

        $companyUser3 = User::updateOrCreate([
            'email' => 'careers@ubagroup.com',
        ], [
            'name' => 'UBA Cameroon HR',
            'password' => Hash::make('password'),
            'role_id' => $roleCompany->id,
        ]);
        $ubaCompany = Company::updateOrCreate([
            'user_id' => $companyUser3->id,
        ], [
            'company_name' => 'United Bank for Africa Cameroon',
            'registration_number' => 'RC/YAE/2024/B/9012',
            'description' => 'Leading financial institution providing banking and financial services across Cameroon',
            'industry' => 'Banking & Finance',
            'website' => 'https://www.ubagroup.com/cm',
            'phone' => '+237 222 200 500',
            'address' => 'UBA Building, Avenue Kennedy',
            'city' => 'Yaoundé',
            'postal_code' => 'BP 3500',
            'country' => 'Cameroon',
            'contact_person' => 'HR Business Partner',
            'contact_email' => 'careers@ubagroup.com',
            'contact_phone' => '+237 222 200 600',
            'company_size' => 'Large',
            'founded_year' => 2006,
        ]);

        // Create Student Users and Students
        $studentUsers = [
            [
                'email' => 'yannick.noah@iuc.cm',
                'name' => 'Yannick Noah',
                'student_number' => 'IUC2024001',
                'university' => 'Institut Universitaire de la Côte',
                'field_of_study' => 'Software Engineering',
                'educational_level' => 'Bachelor',
                'phone' => '+237 677 123 456',
                'graduation_year' => 2025,
            ],
            [
                'email' => 'brenda.biya@iuc.cm',
                'name' => 'Brenda Biya',
                'student_number' => 'IUC2024002',
                'university' => 'Institut Universitaire de la Côte',
                'field_of_study' => 'Network and Telecommunications',
                'educational_level' => 'Bachelor',
                'phone' => '+237 699 234 567',
                'graduation_year' => 2025,
            ],
            [
                'email' => 'marc.dongmo@iuc.cm',
                'name' => 'Marc Dongmo',
                'student_number' => 'IUC2024003',
                'university' => 'Institut Universitaire de la Côte',
                'field_of_study' => 'Computer Science',
                'educational_level' => 'Bachelor',
                'phone' => '+237 677 345 678',
                'graduation_year' => 2025,
            ],
            [
                'email' => 'alice.kamga@iuc.cm',
                'name' => 'Alice Kamga',
                'student_number' => 'IUC2024004',
                'university' => 'Institut Universitaire de la Côte',
                'field_of_study' => 'Information Systems',
                'educational_level' => 'Bachelor',
                'phone' => '+237 699 456 789',
                'graduation_year' => 2025,
            ],
            [
                'email' => 'paul.mbia@iuc.cm',
                'name' => 'Paul Mbía',
                'student_number' => 'IUC2024005',
                'university' => 'Institut Universitaire de la Côte',
                'field_of_study' => 'Cybersecurity',
                'educational_level' => 'Bachelor',
                'phone' => '+237 677 567 890',
                'graduation_year' => 2025,
            ],
        ];

        $students = [];
        foreach ($studentUsers as $studentData) {
            $user = User::updateOrCreate([
                'email' => $studentData['email'],
            ], [
                'name' => $studentData['name'],
                'password' => Hash::make('password'),
                'role_id' => $roleStudent->id,
            ]);

            $student = Student::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'student_number' => $studentData['student_number'],
                'university' => $studentData['university'],
                'field_of_study' => $studentData['field_of_study'],
                'educational_level' => $studentData['educational_level'],
                'phone' => $studentData['phone'],
                'graduation_year' => $studentData['graduation_year'],
                'bio' => 'Motivated ' . $studentData['field_of_study'] . ' student seeking internship opportunities to apply academic knowledge in real-world projects.',
            ]);

            $students[] = $student;
        }

        // Create Internship Offers
        $offers = [
            [
                'company' => $orangeCompany,
                'title' => 'Web Development Internship',
                'description' => 'Join our digital team to work on web applications using modern technologies. You will participate in the development of Orange Cameroun\'s digital platforms and services.',
                'requirements' => 'PHP, Laravel, JavaScript, Vue.js, MySQL, Git. Knowledge of REST APIs and responsive design is a plus.',
                'location' => 'Douala',
                'internship_type' => 'Web Development',
                'application_deadline' => Carbon::now()->addDays(30),
                'start_date' => Carbon::now()->addMonths(1),
                'end_date' => Carbon::now()->addMonths(4),
                'positions_available' => 2,
                'compensation' => 75000,
                'compensation_type' => 'Monthly stipend',
                'benefits' => 'Transportation allowance, Lunch allowance, Health insurance, Training opportunities',
                'skills_required' => 'PHP, Laravel, JavaScript, Vue.js, MySQL',
                'status' => 'active',
                'is_remote' => false,
            ],
            [
                'company' => $orangeCompany,
                'title' => 'Network Security Internship',
                'description' => 'Contribute to securing Orange Cameroun\'s network infrastructure. Learn about network security protocols, firewall management, and cybersecurity best practices.',
                'requirements' => 'Basic knowledge of networking, Cisco certifications preferred, Linux, Security concepts, VPN, Firewall configuration.',
                'location' => 'Yaoundé',
                'internship_type' => 'Network Security',
                'application_deadline' => Carbon::now()->addDays(25),
                'start_date' => Carbon::now()->addMonths(1)->addDays(15),
                'end_date' => Carbon::now()->addMonths(5),
                'positions_available' => 1,
                'compensation' => 80000,
                'compensation_type' => 'Monthly stipend',
                'benefits' => 'Transportation allowance, Internet allowance, Security training, Certification support',
                'skills_required' => 'Networking, Cisco, Linux, Security, Firewall',
                'status' => 'active',
                'is_remote' => false,
            ],
            [
                'company' => $mtnCompany,
                'title' => 'Mobile App Development Internship',
                'description' => 'Develop mobile applications for MTN Cameroon\'s growing digital ecosystem. Work with cross-functional teams to create innovative mobile solutions.',
                'requirements' => 'Java/Kotlin for Android, Swift for iOS, Flutter/React Native, Firebase, REST APIs, Mobile UI/UX principles.',
                'location' => 'Yaoundé',
                'internship_type' => 'Mobile Development',
                'application_deadline' => Carbon::now()->addDays(20),
                'start_date' => Carbon::now()->addMonths(2),
                'end_date' => Carbon::now()->addMonths(5),
                'positions_available' => 3,
                'compensation' => 85000,
                'compensation_type' => 'Monthly stipend',
                'benefits' => 'Mobile data allowance, Device allowance, Training budget, Conference attendance',
                'skills_required' => 'Android, iOS, Flutter, Firebase, APIs',
                'status' => 'active',
                'is_remote' => false,
            ],
            [
                'company' => $ubaCompany,
                'title' => 'IT Support & Systems Administration Internship',
                'description' => 'Support UBA Cameroon\'s IT infrastructure and help maintain banking systems. Gain experience in enterprise IT operations and customer support.',
                'requirements' => 'Windows Server, Linux, Active Directory, SQL Server, Help desk experience, Basic networking, Customer service skills.',
                'location' => 'Douala',
                'internship_type' => 'IT Support',
                'application_deadline' => Carbon::now()->addDays(35),
                'start_date' => Carbon::now()->addMonths(1)->addDays(10),
                'end_date' => Carbon::now()->addMonths(4)->addDays(10),
                'positions_available' => 2,
                'compensation' => 70000,
                'compensation_type' => 'Monthly stipend',
                'benefits' => 'Banking products, Training programs, Certificate courses, Transportation',
                'skills_required' => 'Windows Server, Linux, SQL, Networking, Customer Support',
                'status' => 'active',
                'is_remote' => false,
            ],
            [
                'company' => $mtnCompany,
                'title' => 'Data Analysis & Business Intelligence Internship',
                'description' => 'Analyze MTN Cameroon\'s business data to extract insights and support decision-making. Learn about telecommunications data analytics and reporting.',
                'requirements' => 'SQL, Excel (advanced), Power BI/Tableau, Python for data analysis, Statistics, Data visualization, Business analysis.',
                'location' => 'Yaoundé',
                'internship_type' => 'Data Analysis',
                'application_deadline' => Carbon::now()->addDays(28),
                'start_date' => Carbon::now()->addMonths(2)->addDays(5),
                'end_date' => Carbon::now()->addMonths(5)->addDays(5),
                'positions_available' => 1,
                'compensation' => 78000,
                'compensation_type' => 'Monthly stipend',
                'benefits' => 'Data tools access, Training workshops, Project allowance, Flexible hours',
                'skills_required' => 'SQL, Excel, Power BI, Python, Statistics',
                'status' => 'active',
                'is_remote' => true,
            ],
        ];

        $createdOffers = [];
        foreach ($offers as $offerData) {
            $offer = Offer::updateOrCreate([
                'company_id' => $offerData['company']->id,
                'title' => $offerData['title'],
            ], array_diff_key($offerData, ['company' => '']));

            $createdOffers[] = $offer;
        }

        // Create Applications
        $applications = [
            [
                'student' => $students[0], // Yannick Noah
                'offer' => $createdOffers[0], // Web Development at Orange
                'status' => 'accepted',
                'motivation_letter' => 'I am very interested in web development and believe my skills in PHP and JavaScript would be valuable to Orange Cameroun.',
                'cv_path' => 'cvs/yannick_noah_cv.pdf',
            ],
            [
                'student' => $students[1], // Brenda Biya
                'offer' => $createdOffers[1], // Network Security at Orange
                'status' => 'accepted',
                'motivation_letter' => 'My passion for network security and telecommunications makes this internship opportunity perfect for my career goals.',
                'cv_path' => 'cvs/brenda_biya_cv.pdf',
            ],
            [
                'student' => $students[2], // Marc Dongmo
                'offer' => $createdOffers[2], // Mobile App Development at MTN
                'status' => 'under_review',
                'motivation_letter' => 'I have experience with Android development and would love to contribute to MTN\'s mobile ecosystem.',
                'cv_path' => 'cvs/marc_dongmo_cv.pdf',
            ],
            [
                'student' => $students[3], // Alice Kamga
                'offer' => $createdOffers[3], // IT Support at UBA
                'status' => 'pending',
                'motivation_letter' => 'I am eager to learn about enterprise IT systems and support in a banking environment.',
                'cv_path' => 'cvs/alice_kamga_cv.pdf',
            ],
            [
                'student' => $students[4], // Paul Mbía
                'offer' => $createdOffers[4], // Data Analysis at MTN
                'status' => 'shortlisted',
                'motivation_letter' => 'My analytical skills and Python programming experience would be beneficial for MTN\'s data analysis needs.',
                'cv_path' => 'cvs/paul_mbia_cv.pdf',
            ],
        ];

        $createdApplications = [];
        foreach ($applications as $applicationData) {
            $application = Application::updateOrCreate([
                'student_id' => $applicationData['student']->id,
                'offer_id' => $applicationData['offer']->id,
            ], array_diff_key($applicationData, ['student' => '', 'offer' => '']));

            $createdApplications[] = $application;
        }

        // Create Stages for accepted applications
        $stages = [
            [
                'application' => $createdApplications[0], // Yannick at Orange Web Dev
                'supervisor' => $supervisor1,
                'start_date' => Carbon::now()->addMonths(1),
                'end_date' => Carbon::now()->addMonths(4),
                'status' => 'ongoing',
                'objectives' => 'Develop web applications, learn Laravel framework, contribute to Orange\'s digital projects',
                'stipend_amount' => 75000,
                'stipend_frequency' => 'Monthly',
                'is_paid' => true,
            ],
            [
                'application' => $createdApplications[1], // Brenda at Orange Network Security
                'supervisor' => $supervisor2,
                'start_date' => Carbon::now()->addMonths(1)->addDays(15),
                'end_date' => Carbon::now()->addMonths(5),
                'status' => 'ongoing',
                'objectives' => 'Learn network security protocols, configure firewalls, assist in security audits',
                'stipend_amount' => 80000,
                'stipend_frequency' => 'Monthly',
                'is_paid' => true,
            ],
        ];

        $createdStages = [];
        foreach ($stages as $stageData) {
            $stage = Stage::updateOrCreate([
                'application_id' => $stageData['application']->id,
            ], array_diff_key($stageData, ['application' => '']));

            $createdStages[] = $stage;
        }

        // Create Evaluations
        $evaluations = [
            [
                'stage' => $createdStages[0], // Yannick's stage
                'evaluator' => $supervisor1,
                'evaluation_type' => 'mid_term',
                'evaluation_date' => Carbon::now()->addMonths(2)->addDays(15),
                'technical_skills_rating' => 4,
                'work_quality_rating' => 4,
                'communication_rating' => 5,
                'punctuality_rating' => 5,
                'teamwork_rating' => 4,
                'overall_rating' => 4,
                'strengths' => 'Good understanding of Laravel, proactive in learning new technologies',
                'areas_for_improvement' => 'Could improve code documentation',
                'comments' => 'Yannick is performing well and shows great potential in web development.',
                'recommendations' => 'Continue with current projects and consider advanced Laravel topics',
            ],
            [
                'stage' => $createdStages[1], // Brenda's stage
                'evaluator' => $supervisor2,
                'evaluation_type' => 'mid_term',
                'evaluation_date' => Carbon::now()->addMonths(3),
                'technical_skills_rating' => 5,
                'work_quality_rating' => 5,
                'communication_rating' => 4,
                'punctuality_rating' => 5,
                'teamwork_rating' => 5,
                'overall_rating' => 5,
                'strengths' => 'Excellent technical skills, very dedicated, quick learner',
                'areas_for_improvement' => 'Could be more vocal in team meetings',
                'comments' => 'Brenda has exceeded expectations in network security tasks.',
                'recommendations' => 'Consider offering her a permanent position after graduation',
            ],
        ];

        foreach ($evaluations as $evaluationData) {
            Evaluation::updateOrCreate([
                'stage_id' => $evaluationData['stage']->id,
                'evaluation_type' => $evaluationData['evaluation_type'],
            ], array_diff_key($evaluationData, ['stage' => '']));
        }

        // Create sample notifications
        Notification::create([
            'user_id' => $students[0]->user_id, // Yannick
            'message' => 'Your application for Web Development Internship at Orange Cameroun has been accepted!',
            'read' => false,
        ]);

        Notification::create([
            'user_id' => $students[2]->user_id, // Marc
            'message' => 'Your application for Mobile App Development Internship at MTN Cameroon is under review.',
            'read' => false,
        ]);

        // Create sample messages
        Message::create([
            'sender_id' => $companyUser2->id, // Orange HR
            'receiver_id' => $students[0]->user_id, // Yannick
            'content' => 'Congratulations! Your internship at Orange Cameroun starts on ' . Carbon::now()->addMonths(1)->format('M j, Y') . '. Please report to our Douala office.',
        ]);

        Message::create([
            'sender_id' => $students[0]->user_id, // Yannick
            'receiver_id' => $companyUser2->id, // Orange HR
            'content' => 'Thank you for the opportunity! I\'m excited to start and will report as scheduled.',
        ]);
    }
}
