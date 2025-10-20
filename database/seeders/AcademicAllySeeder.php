<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Task;
use App\Models\Lead;

class AcademicAllySeeder extends Seeder
{
    public function run(): void
    {
        // Create test users (your team)
        $admin1 = User::create([
            'name' => 'Admin One',
            'email' => 'admin1@academically.com',
            'password' => bcrypt('password'),
        ]);

        $admin2 = User::create([
            'name' => 'Admin Two',
            'email' => 'admin2@academically.com',
            'password' => bcrypt('password'),
        ]);

        $admin3 = User::create([
            'name' => 'Admin Three',
            'email' => 'admin3@academically.com',
            'password' => bcrypt('password'),
        ]);

        // Create sample clients
        $client1 = Client::create([
            'name' => 'John Mukasa',
            'email' => 'john@example.com',
            'phone' => '0771234567',
            'whatsapp' => '0771234567',
            'program' => 'Computer Science',
            'year_of_study' => 'Year 3',
            'source' => 'website',
            'status' => 'active',
        ]);

        $client2 = Client::create([
            'name' => 'Sarah Namukasa',
            'email' => 'sarah@example.com',
            'phone' => '0782345678',
            'program' => 'Business Administration',
            'year_of_study' => 'Year 4',
            'source' => 'referral',
            'referral_source' => 'John Mukasa',
            'status' => 'active',
        ]);

        // Create sample projects
        $project1 = Project::create([
            'client_id' => $client1->id,
            'assigned_to' => $admin1->id,
            'service_type' => 'programming',
            'title' => 'E-commerce Website Development',
            'description' => 'Build a full e-commerce website with Laravel',
            'quoted_price' => 2000000,
            'agreed_price' => 1800000,
            'deposit_paid' => 900000,
            'total_paid' => 900000,
            'balance' => 900000,
            'payment_status' => 'deposit_paid',
            'status' => 'in_progress',
            'deadline' => now()->addDays(14),
            'started_at' => now()->subDays(5),
            'estimated_hours' => 40,
            'priority' => 'high',
        ]);

        $project2 = Project::create([
            'client_id' => $client2->id,
            'assigned_to' => $admin2->id,
            'service_type' => 'research_paper',
            'title' => 'Marketing Strategy Research Paper',
            'description' => 'Research paper on digital marketing strategies',
            'quoted_price' => 350000,
            'agreed_price' => 350000,
            'deposit_paid' => 0,
            'total_paid' => 0,
            'balance' => 350000,
            'payment_status' => 'not_paid',
            'status' => 'quoted',
            'deadline' => now()->addDays(7),
            'estimated_hours' => 15,
            'priority' => 'medium',
        ]);

        // Add payment for project 1
        Payment::create([
            'project_id' => $project1->id,
            'client_id' => $client1->id,
            'recorded_by' => $admin1->id,
            'amount' => 900000,
            'payment_method' => 'mobile_money',
            'transaction_reference' => 'MM12345678',
            'payment_type' => 'deposit',
            'payment_date' => now()->subDays(5),
        ]);

        // Add some expenses
        Expense::create([
            'user_id' => $admin1->id,
            'project_id' => $project1->id,
            'category' => 'software',
            'amount' => 50000,
            'description' => 'Hosting for 3 months',
            'expense_date' => now()->subDays(3),
        ]);

        Expense::create([
            'user_id' => $admin2->id,
            'category' => 'data_bundle',
            'amount' => 20000,
            'description' => 'MTN 10GB bundle',
            'expense_date' => now()->subDays(1),
        ]);

        // Add tasks to project 1
        Task::create([
            'project_id' => $project1->id,
            'assigned_to' => $admin1->id,
            'title' => 'Setup Laravel project',
            'description' => 'Initialize Laravel project with authentication',
            'status' => 'completed',
            'due_date' => now()->addDays(1),
            'completed_at' => now()->subDays(4),
            'estimated_minutes' => 120,
            'actual_minutes' => 150,
            'order' => 1,
        ]);

        Task::create([
            'project_id' => $project1->id,
            'assigned_to' => $admin1->id,
            'title' => 'Design database schema',
            'description' => 'Create migrations for products, orders, users',
            'status' => 'completed',
            'due_date' => now()->addDays(3),
            'completed_at' => now()->subDays(3),
            'estimated_minutes' => 180,
            'actual_minutes' => 200,
            'order' => 2,
        ]);

        Task::create([
            'project_id' => $project1->id,
            'assigned_to' => $admin1->id,
            'title' => 'Build product catalog',
            'description' => 'CRUD operations for products with images',
            'status' => 'in_progress',
            'due_date' => now()->addDays(5),
            'estimated_minutes' => 300,
            'order' => 3,
        ]);

        // Add some leads
        Lead::create([
            'name' => 'Peter Okello',
            'phone' => '0793456789',
            'source' => 'whatsapp_group',
            'status' => 'new',
            'inquiry_details' => 'Needs help with final year project - mobile app',
            'service_interested' => 'programming',
        ]);

        Lead::create([
            'name' => 'Mary Nakato',
            'email' => 'mary@example.com',
            'phone' => '0704567890',
            'source' => 'business_card',
            'status' => 'contacted',
            'inquiry_details' => 'Research paper on climate change',
            'service_interested' => 'research_paper',
            'contacted_at' => now()->subHours(2),
        ]);

        // Update client lifetime values
        // $client1->updateLifetimeValue();
        // $client2->updateLifetimeValue();

        echo "Sample data created successfully!\n";
    }
}