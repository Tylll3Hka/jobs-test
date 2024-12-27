<?php



function userVerification():void
{
    if(!isset($_SESSION['user_id']))
        $_SERVER ['DOCUMENT_ROOT'] . header('location: /register.php');

}
function slugExistsInDatabase($slug, $db):bool {
    $stmt = $db->prepare("SELECT COUNT(*) FROM vacancies WHERE slug = ?");
    $stmt->execute([$slug]);
    $count = $stmt->fetchColumn();
    return $count > 0;
}

function generateUniqueSlug($vacancy, $db):string {
    $cyrillicToLatinMap = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
        'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
        'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
        'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ь' => '', 'ъ' => '',
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo',
        'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M',
        'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
        'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch', 'Ы' => 'Y',
        'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
    ];
    $vacancy = strtr($vacancy, $cyrillicToLatinMap);

    $slug = preg_replace('/[^a-zA-Z0-9\s]/', '', $vacancy);
    $slug = str_replace(' ', '_', $slug);

    $slug = substr($slug, 0, 15);

    $uniqueSlug = $slug;
    $counter = 1;

    while (slugExistsInDatabase($uniqueSlug, $db)) {
        $uniqueSlug = $slug . '_' . $counter;
        $counter++;
    }

    return $uniqueSlug ?: $slug;
}

function getVacancies():string
{
    return "SELECT v.*,
            u.login AS user_name,
            u.photo_path AS user_photo_path,
            c.name AS category_name,
            t.name AS type_employment_name
        FROM vacancies AS v 
        INNER JOIN users u ON u.id = v.user_id
        INNER JOIN categories c ON c.id = v.category_id
        INNER JOIN type_employment t ON t.id = v.type_employment_id ";
}


function getCategoriesWithCountVacancies():string
{
    return "SELECT 
    c.id AS category_id,
    c.name AS category_name,
    COUNT(v.category_id) AS usage_count
FROM 
    categories AS c
LEFT JOIN 
    vacancies AS v ON c.id = v.category_id
GROUP BY 
    c.id, c.name
ORDER BY usage_count DESC ";
}
function  getUsersWithCountVacancies()
{
    return "SELECT u.id ,u.login,u.photo_path, 
    COUNT(v.user_id) AS usage_count
FROM 
    users AS u
LEFT JOIN 
    vacancies AS v ON u.id = v.user_id
GROUP BY 
    u.id, u.login
ORDER BY usage_count DESC  LIMIT 4";
}
function generateName():string{
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < 17; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string . ".png";
}

function salaryFormat($number)
{
    if ($number < 1000) {
        return sprintf('%d', $number);
    }

    if ($number < 1000000) {
        $number = $number / 1000;
        return $newVal = number_format($number,1) . 'k';
    }

    if ($number >= 1000000 && $number < 1000000000) {
        $number = $number / 1000000;
        return $newVal = number_format($number,1) . 'M';
    }

    if ($number >= 1000000000 && $number < 1000000000000) {
        $number = $number / 1000000000;
        return $newVal = number_format($number,1) . 'B';
    }

    return sprintf('%d%s', floor($number / 1000000000000), 'T+');
}



