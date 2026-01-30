<?php
// chỉ lấy dữ liệu cần cho dashboard
$stmt = $conn->query("SELECT TOP 1 * FROM motivations ORDER BY NEWID()");
$motivation = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<section class="stats">
    <div class="card">✅ Tasks<br><strong>5 / 8</strong></div>
    <div class="card">🔥 Streak<br><strong>12 days</strong></div>
    <div class="card">💸 Expense<br><strong>$120</strong></div>
    <div class="card">🎯 Goals<br><strong>70%</strong></div>
</section>

<section class="content">
    <div class="card">📅 Task hôm nay</div>

    <div class="card big">
        <h3>🔥 Motivation of the Day</h3>
        <p class="quote">
            <?= htmlspecialchars($motivation['content'] ?? 'Stay consistent.') ?>
        </p>
    </div>

    <div class="card">
        <h3>🎯 Today’s Focus</h3>
        <p>Finish one important task.</p>
    </div>

    <div class="card">
        <h3>🧠 Message to Yourself</h3>
        <p>You promised yourself you would not quit.</p>
    </div>
</section>
