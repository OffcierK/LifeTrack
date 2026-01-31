<?php
require_once "auth.php";
require_once "config/db.php";

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo "<p>Unauthorized</p>";
    exit;
}

$sql = "SELECT id, content, color, pos_x, pos_y
        FROM sticky_notes
        WHERE user_id = ?
        ORDER BY created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content sticky-wall">

    <!-- ===== HEADER ===== -->
    <div class="sticky-header">
        <h2>🧠 Sticky Wall</h2>
    </div>

    <!-- ===== MAIN CANVAS AREA ===== -->
    <div class="sticky-canvas">

        <!-- INFO PANEL (LEFT – VERY LIGHT) -->
        <aside class="sticky-info">
            <h3>Create your notes</h3>
            <p>
                Use sticky notes to quickly capture ideas,
                thoughts, or reminders.
            </p>
            <div class="sticky-tip">
                💡 Drag notes around – everything is saved automatically.
            </div>
        </aside>

        <!-- BOARD -->
        <div class="sticky-board-wrapper">
            <div class="sticky-board" id="stickyBoard">

                <!-- EMPTY STATE -->
                <?php if (empty($notes)): ?>
                    <div class="sticky-empty">
                        <p>No notes yet</p>
                        <b>Create your first note ✨</b>
                    </div>
                <?php endif; ?>

                <!-- SAVED NOTES -->
                <?php foreach ($notes as $note): ?>
                    <div
                        class="sticky-note <?= htmlspecialchars($note['color']) ?>"
                        data-id="<?= (int)$note['id'] ?>"
                        style="
                            left: <?= (int)$note['pos_x'] ?>px;
                            top: <?= (int)$note['pos_y'] ?>px;
                        "
                    >
                        <textarea placeholder="Write something..."><?= htmlspecialchars($note['content']) ?></textarea>
                        <button class="delete-note">✕</button>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- FLOATING ADD BUTTON -->
            <button class="sticky-fab" id="addNoteBtn">＋</button>

        </div>

    </div>

</section>