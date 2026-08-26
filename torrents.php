<?php
require_once __DIR__ . '/inc/common.php';
session_start();
$file = __DIR__ . '/db/torrents.txt';
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) $errors[] = 'CSRF token';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    if ($title === '') $errors[] = 'Title required';
    if ($category === '') $errors[] = 'Category required';
    if ($url === '') $errors[] = 'URL required';
    if (strlen($title) > 200) $errors[] = 'Title too long';
    if (empty($errors)) {
        $entry = array('date'=>date('Y-m-d'),'title'=>$title,'category'=>$category,'url'=>$url);
        append_data_line($file, $entry);
        header('Location: torrents.php');
        exit;
    }
}

$list = array_reverse(read_json_lines($file));
include __DIR__ . '/inc/header.php';
?>
<div class="container">
  <div class="nav"><a href="index.php">Domov</a> | <a href="torrents.php">ISO / Datoteke</a></div>
  <div class="panel">
    <h2>ISO / Datoteke</h2>
    <?php if (!empty($errors)): foreach ($errors as $e): ?><div class="errors"><?php echo e($e); ?></div><?php endforeach; endif; ?>
    <form method="post" action="torrents.php">
      <?php echo csrf_field(); ?>
      Naslov: <input type="text" name="title" /><br/>
      Kategorija: <input type="text" name="category" /><br/>
      URL: <input type="text" name="url" /><br/>
      <input type="submit" value="DODAJ" />
    </form>

    <h3>Seznam</h3>
    <table class="listtable">
      <tr><th>Datum</th><th>Naslov</th><th>Kategorija</th><th>Link</th></tr>
      <?php foreach ($list as $row): ?>
      <tr>
        <td><?php echo e($row['date']); ?></td>
        <td><?php echo e($row['title']); ?></td>
        <td><?php echo e($row['category']); ?></td>
        <td><a href="<?php echo e($row['url']); ?>"><?php echo e($row['url']); ?></a></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
<?php include __DIR__ . '/inc/footer.php'; ?>