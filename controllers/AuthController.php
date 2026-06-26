    <?php

    require_once 'models/User.php';

    class AuthController
    {
        private $userModel;

        public function __construct($db)
        {
            $this->userModel =
            new User($db);
        }

        public function login()
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            {
                return;
            }

            $username =
            trim($_POST['username']);

            $password =
            trim($_POST['password']);

            $user =
            $this->userModel
                ->login($username);

            if (!$user)
            {
                $_SESSION['error'] =
                'Username tidak ditemukan';
                header('Location:?page=login');
                exit;
            }

            if ($user['status_akun'] != 'Aktif')
            {
                $_SESSION['error'] =
                'Akun tidak aktif';

                header('Location:?page=login');
                exit;
            }

            if (!password_verify(
                $password,
                $user['password']
            ))
            {
                $_SESSION['error'] =
                'Password salah';

                header('Location:?page=login');
                exit;
            }

            $_SESSION['user'] = [
            'id'   => $user['id_user'],
            'nama' => $user['nama'],
            'role' => $user['nama_role']
            ];

            if ($user['nama_role'] == 'Admin')
            {
                header(
                    'Location:?page=dashboard-admin'
                );
            }
            else
            {
                header(
                    'Location:?page=dashboard-petugas'
                );
            }

            exit;
        }

        public function logout()
        {
            session_destroy();

            header(
                'Location:?page=login'
            );

            exit;
        }
    }