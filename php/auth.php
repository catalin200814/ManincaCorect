<?php
define('USERS_FILE', __DIR__ . '/../data/users.json');

function getUsers(): array {
    if (!file_exists(USERS_FILE)) return [];
    return json_decode(file_get_contents(USERS_FILE), true) ?? [];
}

function saveUsers(array $users): void {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function registerUser(string $nume, string $email, string $parola, string $confirma): array {
    $nume = trim($nume);
    $email = trim(strtolower($email));
    $parola = trim($parola);

    if (empty($nume) || empty($email) || empty($parola)) {
        return ['success' => false, 'message' => 'Toate câmpurile sunt obligatorii.'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Adresa de email nu este validă.'];
    }
    if (strlen($parola) < 6) {
        return ['success' => false, 'message' => 'Parola trebuie să aibă minim 6 caractere.'];
    }
    if ($parola !== $confirma) {
        return ['success' => false, 'message' => 'Parolele nu coincid.'];
    }

    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return ['success' => false, 'message' => 'Această adresă de email este deja înregistrată.'];
        }
    }

    $newUser = [
        'id' => count($users) + 1,
        'nume' => $nume,
        'email' => $email,
        'parola' => password_hash($parola, PASSWORD_BCRYPT),
        'created_at' => date('Y-m-d H:i:s'),
    ];

    $users[] = $newUser;
    saveUsers($users);
    return ['success' => true, 'message' => 'Cont creat cu succes!'];
}

function loginUser(string $email, string $parola): array {
    $email = trim(strtolower($email));
    $parola = trim($parola);

    if (empty($email) || empty($parola)) {
        return ['success' => false, 'message' => 'Completează toate câmpurile.'];
    }

    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            if (password_verify($parola, $user['parola'])) {
                unset($user['parola']);
                return ['success' => true, 'user' => $user];
            } else {
                return ['success' => false, 'message' => 'Parola este incorectă.'];
            }
        }
    }
    return ['success' => false, 'message' => 'Nu există niciun cont cu această adresă de email.'];
}
?>