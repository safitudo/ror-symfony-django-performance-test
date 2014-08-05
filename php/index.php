<?php
error_reporting(E_ALL);
$title = "PHP app";

$dbhost = 'jamclouds-test.csvocnt4dyzb.us-east-1.rds.amazonaws.com';
$dbname = "jamclouds";
$dbuser = 'jamclouds';
$dbpassword = "a9a0skjs";
try{
    $pdo = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpassword, array(PDO::ATTR_TIMEOUT => "30",PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch(PDOException $e){
    echo $e;
}
sleep(5);
$min_user_id = 10521598;
$max_user_id = $min_user_id + 1000;
//$user_id = 10521598;
$user_id = rand($min_user_id, $max_user_id);
$stmt = $pdo->query('SELECT * FROM fos_user WHERE id='.$user_id);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null;

$stmt = $pdo->query('SELECT Card.*, count(l.card_id) as l_count, count(f.card_id) as f_count
          FROM Card
          LEFT JOIN users_cards_likes l ON Card.id = l.card_id
          LEFT JOIN users_cards_followers f ON Card.id = f.card_id
          WHERE Card.owner_id = '.$user_id.'
          GROUP BY Card.id');
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = null;
$dbh = null;
?>

<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
</head>
<body>
<h1><?php echo $title; ?></h1>
<h1>Cards, owned by <?php echo $user['username'] ?></h1>

<table class="records_list">
<thead>
<tr>
    <th>Id</th>
    <th>Name</th>
    <th>Description</th>
    <th>Likes</th>
    <th>Followers</th>
</tr>
</thead>
<tbody>
<?php foreach($cards as $card){ ?>
<tr>
    <td><?php echo $card['id'] ?></td>
    <td><?php echo $card['name'] ?></td>
    <td><?php echo substr($card['description'], 0, 50); ?>...</td>
    <td><?php echo $card['l_count'] ?></td>
    <td><?php echo $card['f_count'] ?></td>
</tr>
<?php } ?>
</tbody>
</table>


</body></html>
