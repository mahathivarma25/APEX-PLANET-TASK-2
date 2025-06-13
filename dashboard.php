<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }

$_SESSION['posts'] = $_SESSION['posts'] ?? []; // Initialize posts if not set

// Add/Edit functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    if (isset($_POST['id'])) { // Edit post
        $_SESSION['posts'][$_POST['id']] = $content;
    } else { // Add new post
        $_SESSION['posts'][] = $content;
    }
}

// Delete functionality
if (isset($_GET['del'])) {
    unset($_SESSION['posts'][$_GET['del']]);
}
?>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
<a href="logout.php">Logout</a>

<h3><?php echo isset($_GET['edit']) ? 'Edit Post' : 'Add Post'; ?></h3>
<form method="post">
    <?php if (isset($_GET['edit'])): ?>
        <input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>">
        <input type="text" name="content" value="<?php echo htmlspecialchars($_SESSION['posts'][$_GET['edit']]); ?>" required>
        <button type="submit">Update</button>
    <?php else: ?>
        <input type="text" name="content" required placeholder="Enter new post">
        <button type="submit">Add</button>
    <?php endif; ?>
</form>

<h3>Posts</h3>
<ul>
<?php foreach ($_SESSION['posts'] as $id => $post): ?>
    <li>
        <?php echo htmlspecialchars($post); ?>
        <a href="?edit=<?php echo $id; ?>">Edit</a>
        <a href="?del=<?php echo $id; ?>">Delete</a>
    </li>
<?php endforeach; ?>
</ul>
