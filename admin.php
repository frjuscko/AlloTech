<?php
    require('config/database.php');

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: auth.php");
        exit;
    }

    $users = $pdo->query("SELECT * FROM users")->fetchAll();
    $villes = $pdo->query("SELECT * FROM villes")->fetchAll();
    $competences = $pdo->query("SELECT * FROM competences")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Admin Dashboard - Plateforme Techniciens</title>
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
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    <span>AdminTech</span>
                </div>
                <button class="sidebar-close" id="sidebarClose">x</button>
            </div>
            <nav class="sidebar-nav">
                <a href="admin.php" class="nav-item active">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="competences.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                    <span>Compétences</span>
                </a>
                <a href="villes.php" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 2a14 14 0 0 0 0 20 14 14 0 0 0 0-20"/>
                        <path d="M2 12h20"/>
                    </svg>
                    <span>Villes</span>
                </a>
                <a href="profil.html" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span>Profil</span>
                </a>
            </nav>
        </aside>

        <!-- Overlay mobile -->
        <div class="overlay" id="overlay"></div>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Topbar -->
            <header class="topbar">
                <button class="menu-toggle" id="menuToggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <h1 class="page-title">Tableau de bord</h1>
                <div class="admin-info">
                    <span class="admin-name"><?php echo htmlspecialchars($_SESSION['user_prenom']); ?></span>
                    <div class="avatar">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="content">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Techniciens</h3>
                            <p class="stat-number"><?= count($users) ?></p>
                            <span class="stat-change positive">+12 ce mois</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Compétences</h3>
                            <p class="stat-number"><?= count($competences) ?></p>
                            <span class="stat-change">+3 nouvelles</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 2a14 14 0 0 0 0 20 14 14 0 0 0 0-20"/>
                                <path d="M2 12h20"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Villes couvertes</h3>
                            <p class="stat-number"><?= count($villes) ?></p>
                            <span class="stat-change">+5 ce trimestre</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <h3>Inscriptions récentes</h3>
                            <p class="stat-number"><?= count($users) ?></p>
                            <span class="stat-change">7 derniers jours</span>
                        </div>
                    </div>
                </div>

                <!-- Charts & Activities -->
                <div class="dashboard-grid">
                    <!-- Simple Chart -->
                    <div class="card chart-card">
                        <h3>Évolution des inscriptions</h3>
                        <div class="simple-chart" id="simpleChart">
                            <!-- Chart bars generated by JS -->
                        </div>
                        <div class="chart-labels">
                            <span>Lun</span><span>Mar</span><span>Mer</span><span>Jeu</span><span>Ven</span><span>Sam</span><span>Dim</span>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="card activities-card">
                        <h3>Activités récentes</h3>
                        <div class="activities-list" id="activitiesList">
                            <!-- Activities loaded by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        // Dashboard specific initialization
        document.addEventListener('DOMContentLoaded', () => {
            // Generate chart
            const chartData = [25, 32, 38, 42, 48, 35, 30];
            const chartContainer = document.getElementById('simpleChart');
            if(chartContainer) {
                chartContainer.innerHTML = chartData.map(value => 
                    `<div class="chart-bar" style="height: ${value * 2}px"><span>${value}</span></div>`
                ).join('');
            }

            // Generate activities
            const activities = [
                { user: "Sophie Laurent", action: "s'est inscrite comme technicienne", time: "Il y a 2 heures", skill: "Plomberie" },
                { user: "Marc Dubois", action: "a ajouté une compétence", time: "Il y a 5 heures", skill: "Électricité" },
                { user: "Nina Kone", action: "a complété son profil", time: "Hier", skill: "Chauffage" },
                { user: "Lucas Bernard", action: "a modifié ses disponibilités", time: "Hier", skill: "Climatisation" },
                { user: "Emma Petit", action: "s'est inscrite comme cliente", time: "Il y a 2 jours", skill: "Dépannage" }
            ];
            const activitiesList = document.getElementById('activitiesList');
            if(activitiesList) {
                activitiesList.innerHTML = activities.map(act => `
                    <div class="activity-item">
                        <div class="activity-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <div class="activity-details">
                            <p><strong>${act.user}</strong> ${act.action}</p>
                            <small>${act.time} • ${act.skill}</small>
                        </div>
                    </div>
                `).join('');
            }
        });
    </script>
</body>
</html>