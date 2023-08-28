<html>
    <head>
        <title>Viktor - Intently Test</title>
        <link rel="stylesheet" href="assets/css/style.css" />
    </head>

    <body>
        <?php
            // Some assistance was done by ChatGPT, Github Copilot and StackOverflow
            ini_set('memory_limit', '5000M');
            ini_set('max_execution_time', '0');

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            require_once __DIR__ . '/vendor/autoload.php';

            use App\DB\Database;
            use App\DB\User;
            use App\Helpers\PasswordCracker;

            $db = new Database();
            $user = new User($db);
            $cracker = new PasswordCracker();

            $users = $user->getAllUsers();

            $results = [
                'easy' => [],
                'medium1' => [],
                'medium2' => [],
                'hard' => []
            ];

            foreach ($users as $user) {
                $password = $user['password'];
                
                // Easy
                $cracking = $cracker->crackEasyPasswords($password);
                if ($cracking) {
                    $results['easy'][] = [
                        'user_id' => $user['user_id'],
                        'password' => $cracking,
                    ];
                }
                
                // Medium 1
                $cracking = $cracker->crackFirstTypeMediumPasswords($password);
                if ($cracking) {
                    $results['medium1'][] = [
                        'user_id' => $user['user_id'],
                        'password' => $cracking,
                    ];
                }
    
                // Medium 2
                $cracking = $cracker->crackSecondTypeMediumPasswords($password);
                if ($cracking) {
                    $results['medium2'][] = [
                        'user_id' => $user['user_id'],
                        'password' => $cracking,
                    ];
                }
    
                // Hard
                $cracking = $cracker->crackHardPasswords($password);
                if ($cracking) {
                    $results['hard'][] = [
                        'user_id' => $user['user_id'],
                        'password' => $cracking,
                    ];
                }
            }
        ?>

        <h1>Results</h1>
        
        <div class="results">    
            <div>
                <h2>Easy</h2>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results['easy'] as $result) { ?>
                            <tr>
                                <td><?= $result['user_id'] ?></td>
                                <td><?= $result['password'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div>
                <h2>Medium 1</h2>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results['medium1'] as $result) { ?>
                            <tr>
                                <td><?= $result['user_id'] ?></td>
                                <td><?= $result['password'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div>
                <h2>Medium 2</h2>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results['medium2'] as $result) { ?>
                            <tr>
                                <td><?= $result['user_id'] ?></td>
                                <td><?= $result['password'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div>
                <h2>Hard</h2>
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results['hard'] as $result) { ?>
                            <tr>
                                <td><?= $result['user_id'] ?></td>
                                <td><?= $result['password'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
