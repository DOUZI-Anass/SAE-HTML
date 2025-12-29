<?php
require 'config.php';
header('Content-Type: application/json; charset=utf-8');

$stmt = $pdo->query("
  SELECT id_evenement, titre, date_evenement, lieu, budget, description
  FROM evenement
  ORDER BY date_evenement ASC
");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$events = [];
foreach ($rows as $r) {
    $events[] = [
        'id'    => (int)$r['id_evenement'],
        'title' => $r['titre'] ?? '(Sans titre)',
        'start' => $r['date_evenement'], // format YYYY-MM-DD
        'allDay' => true,
        'extendedProps' => [
            'lieu' => $r['lieu'],
            'budget' => $r['budget'],
            'description' => $r['description']
        ]
    ];
}

echo json_encode($events, JSON_UNESCAPED_UNICODE);
//