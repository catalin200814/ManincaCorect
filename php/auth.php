<?php
// ── Calea spre fișierul JSON cu utilizatori ──
define('USERS_FILE', __DIR__ . '/../data/users.json');

// ── Citire utilizatori din JSON ──
function getUsers(): array {
    if (!file_exists(USERS_FILE)) {
        return [];
    }
    $content = file_get_contents(USERS_FILE);
    return json_decode($content, true) ?? [];
}

// ── Salvare utilizatori în JSON ──
function saveUsers(array $users): void {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// ── Înregistrare utilizator nou ──
function registerUser(string $nume, string $email, string $parola, string $confirma): array {
    $nume   = trim($nume);
    $email  = trim(strtolower($email));
    $parola = trim($parola);

    // Validări
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

    // Verificare email duplicat
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return ['success' => false, 'message' => 'Această adresă de email este deja înregistrată.'];
        }
    }

    // Creare utilizator nou
    $newUser = [
        'id'         => count($users) + 1,
        'nume'       => $nume,
        'email'      => $email,
        'parola'     => password_hash($parola, PASSWORD_BCRYPT),
        'created_at' => date('Y-m-d H:i:s'),
    ];

    $users[] = $newUser;
    saveUsers($users);

    return ['success' => true, 'message' => 'Cont creat cu succes!'];
}

// ── Autentificare utilizator ──
function loginUser(string $email, string $parola): array {
    $email  = trim(strtolower($email));
    $parola = trim($parola);

    if (empty($email) || empty($parola)) {
        return ['success' => false, 'message' => 'Completează toate câmpurile.'];
    }

    $users = getUsers();

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            if (password_verify($parola, $user['parola'])) {
                // Nu trimitem parola în sesiune
                unset($user['parola']);
                return ['success' => true, 'user' => $user];
            } else {
                return ['success' => false, 'message' => 'Parola este incorectă.'];
            }
        }
    }

    return ['success' => false, 'message' => 'Nu există niciun cont cu această adresă de email.'];
}