<?php // recommendet way by documentation
//addToGroup() ist eine Methode der User-Entity, nicht des UserModel (Provider).

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = auth()->getProvider();

        $seedUsers = [
            ['email' => 'superadmin@test.de', 'username' => 'superadmin', 'group' => 'superadmin'],
            ['email' => 'admin@test.de',      'username' => 'admin',      'group' => 'admin'],
            ['email' => 'reader@test.de',     'username' => 'reader',     'group' => 'reader'],
        ];

        foreach ($seedUsers as $data) {
            $user = new User([
                'email'    => $data['email'],
                'username' => $data['username'],
                'password' => 'password123',
                'active'   => 1,
            ]);

            $users->save($user);

            // Entity nach dem Save mit ID neu laden
            $saved = $users->findById($users->getInsertID());
            $saved->addGroup($data['group']); // correct way: on Entity
        }
    }
}

// for activating: "php spark db:seed UserSeeder" in cmd
