<?php
echo "<div href='cleanup.php' style='color: red;'>Cleaning all JSON temp files..</div>";
$files = glob('json/*');
foreach($files as $file){
  if(is_file($file))
    unlink($file);
}
echo "<div href='cleanup.php' style='color: red;'>Done!</div>";
 ?>
 <script>
 if (window.confirm('Cleanup done!'))
 {
     alert('Returning to admin..');
     window.location = 'admin.php';
 }
 else
 {
     die();
 }
</script>
