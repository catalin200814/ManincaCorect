<?php
function getUserDataFile(int $userId): string {
    return __DIR__ . '/../data/user_' . $userId . '_meals.json';
}

function loadUserMeals(int $userId): array {
    $file = getUserDataFile($userId);
    if (!file_exists($file)) {
        return [
            'weekly_plan' => [
                'Luni' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
                'Marti' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
                'Miercuri' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
                'Joi' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
                'Vineri' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
                'Sambata' => ['mic_dejun' => '', 'pranz' => '', 'cina' => ''],
                'Duminica' => ['mic_dejun' => '', 'pranz' => '', 'cina' => '']
            ],
            'shopping_list' => [],
            'recipes' => [
                ['id' => 1, 'name' => 'Omletă cu brânză', 'ingredients' => ['ouă', 'brânză', 'sare', 'piper']],
                ['id' => 2, 'name' => 'Salată Caesar', 'ingredients' => ['salată', 'pui', 'parmezan', 'sos Caesar']],
                ['id' => 3, 'name' => 'Paste carbonara', 'ingredients' => ['paste', 'bacon', 'ouă', 'parmezan']]
            ]
        ];
    }
    return json_decode(file_get_contents($file), true);
}

function saveUserMeals(int $userId, array $data): void {
    $file = getUserDataFile($userId);
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>