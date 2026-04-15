<?php
    require('config/database.php');
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: auth.php");
        exit;
    }

    $competences = $pdo->query("SELECT * FROM competences")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Compétences - AdminTech</title>
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-2zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    <span>AdminTech</span>
                </div>
                <button class="sidebar-close" id="sidebarClose">x</button>
            </div>
            <nav class="sidebar-nav">
                <a href="admin.php" class="nav-item">Dashboard</a>
                <a href="competences.php" class="nav-item active">Compétences</a>
                <a href="villes.php" class="nav-item">Villes</a>
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
                <h1 class="page-title">Gestion des compétences</h1>
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
                    <button class="btn btn-primary" id="openSkillModal">+ Ajouter une compétence</button>
                </div>

                <div class="card">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Nom de la compétence</th>
                                    <th>Nombre de techniciens</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="">
                                <?php foreach ($competences as $competence): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($competence['id']) ?></td>
                                                <td><?= htmlspecialchars($competence['code']) ?></td>
                                                <td><strong><?= htmlspecialchars($competence['libelle']) ?></strong></td>
                                                <td>0</td>
                                                <td class="actions-cell">
                                                    <button class="btn-icon edit-skill" data-id=" . <? htmlspecialchars($competence['id']) ?> . ">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M17 3l4 4-7 7H10v-4l7-7z"/>
                                                            <path d="M4 20h16"/>
                                                        </svg>
                                                    </button>
                                                    <button class="btn-icon delete-skill" data-id=" . <? htmlspecialchars($competence['id']) ?> . ">
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

    <!-- Modal for add/edit -->
    <div class="modal" id="skillModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Ajouter une compétence</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="skillForm" action="addSkill.php" method="post">
                    <input type="hidden" id="skillId">
                    <div class="form-group">
                        <label for="skillName">Code de la compétence</label>
                        <input type="text" name="code" id="skillName" class="form-control" required placeholder="Ex: Plomb, Elctr...">
                    </div>
                    <div class="form-group">
                        <label for="skillName">Nom de la compétence</label>
                        <input type="text" name="libelle" id="skillName" class="form-control" required placeholder="Ex: Plomberie, Électricité...">
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary modal-close">Annuler</button>
                <button type="submit" name="submit" class="btn btn-primary" id="saveSkill">Enregistrer</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        // Skills management
        let skills = [
            { id: 1, name: "Plomberie", technicians: 24, status: "actif" },
            { id: 2, name: "Électricité", technicians: 31, status: "actif" },
            { id: 3, name: "Chauffage", technicians: 18, status: "actif" },
            { id: 4, name: "Climatisation", technicians: 22, status: "actif" },
            { id: 5, name: "Menuiserie", technicians: 12, status: "actif" },
            { id: 6, name: "Peinture", technicians: 15, status: "inactif" }
        ];

        function renderSkills() {
            const tbody = document.getElementById('skillsTableBody');
            if(!tbody) return;
            tbody.innerHTML = skills.map(skill => `
                <tr>
                    <td>${skill.id}</td>
                    <td><strong>${skill.name}</strong></td>
                    <td>${skill.technicians} techniciens</td>
                    <td><span class="badge ${skill.status === 'actif' ? 'badge-success' : 'badge-warning'}">${skill.status}</span></td>
                    <td class="actions-cell">
                        <button class="btn-icon edit-skill" data-id="${skill.id}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 3l4 4-7 7H10v-4l7-7z"/>
                                <path d="M4 20h16"/>
                            </svg>
                        </button>
                        <button class="btn-icon delete-skill" data-id="${skill.id}">
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

            // Add event listeners
            document.querySelectorAll('.edit-skill').forEach(btn => {
                btn.addEventListener('click', () => editSkill(parseInt(btn.dataset.id)));
            });
            document.querySelectorAll('.delete-skill').forEach(btn => {
                btn.addEventListener('click', () => deleteSkill(parseInt(btn.dataset.id)));
            });
        }

        let currentEditId = null;
        const modal = document.getElementById('skillModal');
        const modalTitle = document.getElementById('modalTitle');
        const skillNameInput = document.getElementById('skillName');
        const skillIdInput = document.getElementById('skillId');

        function openModal(editMode = false, skill = null) {
            if(editMode && skill) {
                modalTitle.textContent = 'Modifier la compétence';
                skillNameInput.value = skill.name;
                skillIdInput.value = skill.id;
                currentEditId = skill.id;
            } else {
                modalTitle.textContent = 'Ajouter une compétence';
                skillNameInput.value = '';
                skillIdInput.value = '';
                currentEditId = null;
            }
            modal.classList.add('active');
        }

        function closeModal() {
            modal.classList.remove('active');
        }

        function saveSkill() {
            const name = skillNameInput.value.trim();
            if(!name) return;

            if(currentEditId) {
                // Update
                const index = skills.findIndex(s => s.id === currentEditId);
                if(index !== -1) {
                    skills[index].name = name;
                }
            } else {
                // Add new
                const newId = Math.max(...skills.map(s => s.id), 0) + 1;
                skills.push({
                    id: newId,
                    name: name,
                    technicians: 0,
                    status: "actif"
                });
            }
            renderSkills();
            closeModal();
        }

        function editSkill(id) {
            const skill = skills.find(s => s.id === id);
            if(skill) openModal(true, skill);
        }

        function deleteSkill(id) {
            if(confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')) {
                skills = skills.filter(s => s.id !== id);
                renderSkills();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderSkills();
            document.getElementById('openSkillModal')?.addEventListener('click', () => openModal(false));
            document.getElementById('saveSkill')?.addEventListener('click', saveSkill);
            document.querySelectorAll('.modal-close').forEach(btn => {
                btn.addEventListener('click', closeModal);
            });
            modal?.addEventListener('click', (e) => {
                if(e.target === modal) closeModal();
            });
        });
    </script>
</body>
</html>