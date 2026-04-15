<?php
    require('config/database.php');
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: auth.php");
        exit;
    }

    $villes = $pdo->query("SELECT * FROM villes")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Villes - AdminTech</title>
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <div class="app-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-2zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    <span>AdminTech</span>
                </div>
                <button class="sidebar-close" id="sidebarClose">×</button>
            </div>
            <nav class="sidebar-nav">
                <a href="admin.php" class="nav-item">Dashboard</a>
                <a href="competences.php" class="nav-item">Compétences</a>
                <a href="villes.php" class="nav-item active">Villes</a>
                <a href="profil.html" class="nav-item">Profil</a>
            </nav>
        </aside>

        <div class="overlay" id="overlay"></div>

        <main class="main-content">
            <header class="topbar">
                <button class="menu-toggle" id="menuToggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <h1 class="page-title">Gestion des villes</h1>
                <div class="admin-info">
                    <span class="admin-name">Thomas Martin</span>
                    <div class="avatar">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
            </header>

            <div class="content">
                <div class="page-actions">
                    <button class="btn btn-primary" id="openCityModal">+ Ajouter une ville</button>
                </div>

                <div class="card">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>code</th>
                                    <th>Nom de la ville</th>
                                    <th>Techniciens</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="">
                                <?php foreach ($villes as $ville): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($ville['id']) ?></td>
                                                <td><?= htmlspecialchars($ville['code']) ?></td>
                                                <td><strong><?= htmlspecialchars($ville['nom']) ?></strong></td>
                                                <td>0</td>
                                                <td class="actions-cell">
                                                    <button class="btn-icon edit-skill" data-id=" . <? htmlspecialchars($ville['id']) ?> . ">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M17 3l4 4-7 7H10v-4l7-7z"/>
                                                            <path d="M4 20h16"/>
                                                        </svg>
                                                    </button>
                                                    <button class="btn-icon delete-skill" data-id=" . <? htmlspecialchars($ville['id']) ?> . ">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <polyline points="3 6 5 6 21 6"/>
                                                            <path d="M8 6V4h8v2"/>
                                                            <rect x="10" y="11" width="4" height="8"/>
                                                            <rect x="6" y="11" width="4" height="8"/>
                                                            <rect x="14" y="11" width="4" height="8"/>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal for add/edit city -->
    <div class="modal" id="cityModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="cityModalTitle">Ajouter une ville</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="cityForm" action="addVille.php" method="post">
                    <input type="hidden" id="cityId">
                    <div class="form-group">
                        <label for="cityZip">Code</label>
                        <input type="text" name="code" id="cityZip" class="form-control" placeholder="Ex: CLV">
                    </div>
                    <div class="form-group">
                        <label for="cityName">Nom de la ville</label>
                        <input type="text" name="nom" id="cityName" class="form-control" required placeholder="Ex: Paris, Lyon...">
                    </div>                
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary modal-close">Annuler</button>
                <button type="submit" name="submit" class="btn btn-primary" id="saveCity">Enregistrer</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        let cities = [
            { id: 1, name: "Paris", zip: "75001", technicians: 42 },
            { id: 2, name: "Lyon", zip: "69001", technicians: 28 },
            { id: 3, name: "Marseille", zip: "13001", technicians: 35 },
            { id: 4, name: "Bordeaux", zip: "33000", technicians: 19 },
            { id: 5, name: "Lille", zip: "59000", technicians: 23 }
        ];

        function renderCities() {
            const tbody = document.getElementById('citiesTableBody');
            if(!tbody) return;
            tbody.innerHTML = cities.map(city => `
                <tr>
                    <td>${city.id}</td>
                    <td><strong>${city.name}</strong></td>
                    <td>${city.zip}</td>
                    <td>${city.technicians} techniciens</td>
                    <td class="actions-cell">
                        <button class="btn-icon edit-city" data-id="${city.id}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 3l4 4-7 7H10v-4l7-7z"/>
                                <path d="M4 20h16"/>
                            </svg>
                        </button>
                        <button class="btn-icon delete-city" data-id="${city.id}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M8 6V4h8v2"/>
                                <rect x="10" y="11" width="4" height="8"/>
                                <rect x="6" y="11" width="4" height="8"/>
                                <rect x="14" y="11" width="4" height="8"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            `).join('');

            document.querySelectorAll('.edit-city').forEach(btn => {
                btn.addEventListener('click', () => editCity(parseInt(btn.dataset.id)));
            });
            document.querySelectorAll('.delete-city').forEach(btn => {
                btn.addEventListener('click', () => deleteCity(parseInt(btn.dataset.id)));
            });
        }

        let currentCityId = null;
        const cityModal = document.getElementById('cityModal');
        const cityModalTitle = document.getElementById('cityModalTitle');
        const cityNameInput = document.getElementById('cityName');
        const cityZipInput = document.getElementById('cityZip');
        const cityIdInput = document.getElementById('cityId');

        function openCityModal(editMode = false, city = null) {
            if(editMode && city) {
                cityModalTitle.textContent = 'Modifier la ville';
                cityNameInput.value = city.name;
                cityZipInput.value = city.zip;
                cityIdInput.value = city.id;
                currentCityId = city.id;
            } else {
                cityModalTitle.textContent = 'Ajouter une ville';
                cityNameInput.value = '';
                cityZipInput.value = '';
                cityIdInput.value = '';
                currentCityId = null;
            }
            cityModal.classList.add('active');
        }

        function closeCityModal() {
            cityModal.classList.remove('active');
        }

        function saveCity() {
            const name = cityNameInput.value.trim();
            const zip = cityZipInput.value.trim();
            if(!name) return;

            if(currentCityId) {
                const index = cities.findIndex(c => c.id === currentCityId);
                if(index !== -1) {
                    cities[index].name = name;
                    cities[index].zip = zip;
                }
            } else {
                const newId = Math.max(...cities.map(c => c.id), 0) + 1;
                cities.push({
                    id: newId,
                    name: name,
                    zip: zip,
                    technicians: 0
                });
            }
            renderCities();
            closeCityModal();
        }

        function editCity(id) {
            const city = cities.find(c => c.id === id);
            if(city) openCityModal(true, city);
        }

        function deleteCity(id) {
            if(confirm('Supprimer cette ville ?')) {
                cities = cities.filter(c => c.id !== id);
                renderCities();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderCities();
            document.getElementById('openCityModal')?.addEventListener('click', () => openCityModal(false));
            document.getElementById('saveCity')?.addEventListener('click', saveCity);
            document.querySelectorAll('#cityModal .modal-close').forEach(btn => {
                btn.addEventListener('click', closeCityModal);
            });
            cityModal?.addEventListener('click', (e) => {
                if(e.target === cityModal) closeCityModal();
            });
        });
    </script>
</body>
</html>