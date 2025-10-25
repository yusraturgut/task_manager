<?php include "partials/index-header.php" ?>
<div class="container text-center">
        <div class="row justify-content-center">
        <navbar class="navbar navbar-expand-lg bg-body-tertiary rounded-4 ">
    <a class="navbar-brand mx-auto">Görev Kayıt Otomasyonu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
            <div class="rowhead">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Anasayfa </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kayit.php">Kayıt Ol</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="giris.php">Giriş Yap</a>
            </li>
        </ul>
    </div>
    </div>
</navbar>
<div class="container-fluid">
    <div class="header-card mt-4">
        <h1 class="text-center mt-1">
            <i class="bi bi-check2-circle"></i> Yapılacaklar Listesi
        </h1>
        <form id="taskForm" class="mt-4">
            <div class="input-group input-group-lg">
                <input type="text"
                       id="taskInput"
                       class="form-control"
                       placeholder="Yeni görev ekle..."
                       required
                       autocomplete="off">
                <button class="btn btn-primary btn-action" type="submit">
                    <i class="bi bi-plus-circle"></i> Ekle
                </button>
            </div>
        </form>
    </div>
    </form>
    <div class="task-card">
        <h4 class="mb-4">
            <i class="bi bi-list-task"></i> Yapılacaklar
        </h4>
        <div id="taskList"></div>
        <div class="row">
            <div class="col-md-4 border border-info rounded-3 bg-info-subtle text-success-emphasis mr-4">
                <div class="stat-card">
                    <div class="stat-number" id="totalCount">0</div>
                    <div class="stat-label">Toplam Yapılanlar</div>
                </div>
            </div>
            <div class="col-md-4 border border-danger rounded-3 bg-danger-subtle text-success-emphasis mr-4">
                <div class="stat-card">
                    <div class="stat-number" id="pendingCount">0</div>
                    <div class="stat-label">Bekleyen</div>
                </div>
            </div>
            <div class="col-md-4 border border-success rounded-3 bg-success-subtle text-success-emphasis ">
                <div class="stat-card ">
                    <div class="stat-number text-center" id="completedCount">0</div>
                    <div class="stat-label text-center">Tamamlanan</div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<?php include "partials/index-footer.php" ?>
