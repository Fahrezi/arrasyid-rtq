<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@arrasyid.com'],
            ['name' => 'Admin Arrasyid', 'password' => Hash::make('arrasyid2026!'), 'role' => 'super_admin'],
        );

        $program = Program::create([
            'name'        => 'Program Utama RTQ Ar-Rasyid',
            'slug'        => 'program-utama-rtq-ar-rasyid',
            'description' => 'Program utama Rumah Tahfidz Al-Qur\'an Ar-Rasyid Sawah Lunto.',
            'status'      => 'active',
        ]);

        $activities = [
            [
                'name'              => 'Tahfidz Qur\'an',
                'description'       => 'Program hafalan Al-Qur\'an intensif yang dirancang untuk anak-anak dan santri dengan metode talaqqi langsung dari ustadz berpengalaman. Setiap santri dibimbing secara personal untuk memperkuat makhraj, tajwid, dan kelancaran hafalan hingga 30 juz.',
                'activity_date'     => '2025-01-01',
                'proof_of_activity' => 'activities/proofs/tahfidz-quran.jpeg',
            ],
            [
                'name'              => 'Tadabur Alam',
                'description'       => 'Kegiatan tadabur alam mengajak santri mendekatkan diri kepada Allah melalui refleksi dan penghayatan tanda-tanda kebesaran-Nya di alam semesta. Melalui program ini, santri membangun keterhubungan spiritual sekaligus mempererat ukhuwah antar sesama.',
                'activity_date'     => '2025-03-15',
                'proof_of_activity' => 'activities/proofs/tadabur-alam.jpeg',
            ],
            [
                'name'              => 'Fiqh Ibadah',
                'description'       => 'Pembelajaran fiqh ibadah yang membimbing santri memahami tata cara ibadah sesuai syariat secara mendalam dan benar. Materi mencakup thaharah, shalat, puasa, zakat, dan ibadah harian lainnya agar santri mampu beribadah dengan penuh kesadaran dan keyakinan.',
                'activity_date'     => '2025-06-10',
                'proof_of_activity' => 'activities/proofs/fiqh-ibadah.jpeg',
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create([
                'program_id'        => $program->id,
                'name'              => $activity['name'],
                'description'       => $activity['description'],
                'activity_date'     => $activity['activity_date'],
                'proof_of_activity' => $activity['proof_of_activity'],
            ]);
        }
    }
}
