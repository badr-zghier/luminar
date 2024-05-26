<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class RolesPermisstionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create Roles
        $adminRole = Role::create(["name" => "admin"]);
        $teacherRole = Role::create(["name" => "teacher"]);
        $studentRole = Role::create(["name" => "student"]);

        //Define Permissions
        $permissions = [
            'delete_course', 'update_course', 'upload_course', 'view_course', 'delete_video',
            'update_video', 'upload_video', 'view_video', 'delete_quiz', 'update_quiz',
            'upload_quiz', 'solve_quiz', 'rate_course', 'rate_teacher', 'like_video', 'dislike_video',
            'index_courses', 'index_students', 'index_teachers'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }


        //In case you want to change permission , delete all then add new ones,
        //since we can not use syncpermissions

        $adminRole->givePermissionTo([]);
        $teacherRole->givePermissionTo([]);
        $studentRole->givePermissionTo([]);

        // add permissions on top of each one


        $adminRole->givePermissionTo([
            'delete_course', 'update_course', 'upload_course', 'view_course', 'delete_video',
            'update_video', 'upload_video', 'view_video', 'delete_quiz', 'update_quiz',
            'upload_quiz',
            'index_courses', 'index_students', 'index_teachers'
        ]);

        $teacherRole->givePermissionTo([
            'upload_course', 'view_course', 'upload_video', 'view_video', 'upload_quiz',

        ]);

        $studentRole->givePermissionTo([
            'view_course', 'view_video', 'solve_quiz', 'rate_course', 'rate_teacher', 'like_video', 'dislike_video',
        ]);

        // Create Users and assing Roles
        //Admin User
        $adminUser = User::factory()->create([
            'name' => 'adminUser',
            'email' => 'admin@luminar.com',
            'password' => bcrypt('secret'),
            'role' => 'admin',
        ]);

        $adminUser->assignRole('admin');
        $adminPermisions = $adminRole->permissions()->pluck('name')->toArray();
        $adminUser->givePermissionTo($adminPermisions);

        //Teacher User
        $teacherUser = User::factory()->create([
            'name' => 'teacherUser',
            'email' => 'teacher@luminar/com',
            'password' => bcrypt('secret'),
            'role' => 'tacher'
        ]);

        $teacherUser->assignRole('teacher');
        $teacherPermissions = $teacherRole->permissions()->pluck('name')->toArray();
        $teacherUser->givePermissionTo($teacherPermissions);

        //Student User
        $studentUser = User::factory()->create([
            'name' => 'studentUser',
            'email' =>  'student@luminar.com',
            'password' => bcrypt('secret'),
            'role' => 'student'
        ]);

        $studentUser->assignRole('student');
        $studentPermissions = $studentRole->permissions()->pluck('name')->toArray();
        $studentUser->givePermissionTo($studentPermissions);
    }
}
