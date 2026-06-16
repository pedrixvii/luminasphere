<?php foreach ($buku as $item): ?>
    <div class="book">
        <h3><?= $item['volumeInfo']['title'] ?? 'No Title' ?></h3>
        <p><strong>Authors:</strong> <?= implode(', ', $item['volumeInfo']['authors'] ?? ['Unknown']) ?></p>
        <p><strong>Publisher:</strong> <?= $item['volumeInfo']['publisher'] ?? 'Unknown' ?></p>
        <p><strong>Description:</strong> <?= $item['volumeInfo']['description'] ?? 'No Description' ?></p>
        <img src="<?= $item['volumeInfo']['imageLinks']['thumbnail'] ?? 'default_image.jpg' ?>" alt="Book Cover" style="max-width: 100px;">
        <form action="<?= base_url('buku/saveBook') ?>" method="post">
            <input type="hidden" name="title" value="<?= $item['volumeInfo']['title'] ?? '' ?>">
            <input type="hidden" name="authors" value="<?= implode(', ', $item['volumeInfo']['authors'] ?? []) ?>">
            <input type="hidden" name="publisher" value="<?= $item['volumeInfo']['publisher'] ?? '' ?>">
            <input type="hidden" name="description" value="<?= $item['volumeInfo']['description'] ?? '' ?>">
            <input type="hidden" name="published_date" value="<?= $item['volumeInfo']['publishedDate'] ?? '' ?>">
            <input type="hidden" name="image_url" value="<?= $item['volumeInfo']['imageLinks']['thumbnail'] ?? '' ?>">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
<?php endforeach; ?>
