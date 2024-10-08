<?= $this->extend('layouts/sidebar') ?>

<?= $this->section('title') ?>
Daftar Acara
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/header') ?>

<div class="container mt-5">
    <h2>Daftar Acara</h2>

    <div class="d-flex justify-content-between mb-3">
        <!-- Tambah Acara -->
        <a href="/kegiatan/create" class="btn btn-primary">Tambah</a>

        <!-- Search Form -->
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search">
    </div>

    <!-- Table -->
    <table class="table table-bordered table-hover" id="kegiatan">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Acara</th>
                <th>PIC</th>
                <th>Tim</th>
                <th>Lokasi</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($kegiatan as $row): ?>
            <tr>
                <td><?= $row['id_acara']; ?></td>
                <td><?= $row['nama_acara']; ?></td>
                <td><?= $row['pic']; ?></td>
                <td><?= $row['tim_tugas']; ?></td>
                <td><?= $row['lokasi']; ?></td>
                <td><?= $row['waktu_acara']; ?></td>
                <td><?= $row['status_kegiatan']; ?></td>
                <td>
                    <a href="/kegiatan/edit/<?= $row['id_acara']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/kegiatan/delete/<?= $row['id_acara']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus acara ini?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="pra_produksi">Selanjutnya</a></p>

    <!-- Pagination -->
    <nav id="paginationNav">
        <ul class="pagination">
            <!-- Pagination items will be generated by JavaScript -->
        </ul>
    </nav>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const itemsPerPageSelect = document.getElementById('itemsPerPage');
    const searchInput = document.getElementById('searchInput');
    const kegiatan = document.getElementById('kegiatan');
    const tableRows = Array.from(kegiatan.querySelectorAll('tbody tr'));
    const paginationNav = document.getElementById('paginationNav');

    let itemsPerPage = parseInt(itemsPerPageSelect.value);
    let currentPage = 1;

    function updateTable() {
        // Get the search term
        const searchTerm = searchInput.value.toLowerCase();

        // Filter rows based on the search term
        const filteredRows = tableRows.filter(row => {
            const cells = row.getElementsByTagName('td');
            let match = false;
            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(searchTerm)) {
                    match = true;
                    break;
                }
            }
            return match;
        });

        // Pagination
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / itemsPerPage);

        // Show only rows for the current page
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        tableRows.forEach(row => row.style.display = 'none'); // Hide all rows
        filteredRows.slice(startIndex, endIndex).forEach(row => row.style.display = '');

        // Update pagination controls
        paginationNav.querySelector('ul').innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement('li');
            pageItem.className = 'page-item';
            pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageItem.addEventListener('click', () => {
                currentPage = i;
                updateTable();
            });
            paginationNav.querySelector('ul').appendChild(pageItem);
        }

        // Highlight the current page
        paginationNav.querySelectorAll('.page-item').forEach(item => {
            item.classList.toggle('active', item.textContent.trim() == currentPage);
        });
    }

    // Event listeners
    itemsPerPageSelect.addEventListener('change', () => {
        itemsPerPage = parseInt(itemsPerPageSelect.value);
        currentPage = 1; // Reset to first page
        updateTable();
    });

    searchInput.addEventListener('input', updateTable);

    // Initial update
    updateTable();
});
</script>

<?= $this->endSection() ?>
