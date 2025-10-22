<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JTL Lizenzmanagement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 30px;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .btn-custom {
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            margin: 10px;
        }
        .navigation-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">
                <i class="fas fa-key me-3"></i>JTL Lizenzmanagement
            </h1>
            <p class="lead mb-4">Moderne Webanwendung zur Verwaltung und Validierung von Softwarelizenzen</p>
            <p class="mb-5">Migration von monolithischer Architektur zu Cloud-Microservices</p>
            
            <!-- Haupt-Navigation -->
            <div class="navigation-card">
                <h3 class="mb-4">App Navigation</h3>
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ url('/') }}" class="btn btn-outline-primary btn-custom w-100">
                            <i class="fas fa-home me-2"></i>Startseite
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('licenses.index') }}" class="btn btn-primary btn-custom w-100">
                            <i class="fas fa-list me-2"></i>Lizenz-Übersicht
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('validate.form') }}" class="btn btn-success btn-custom w-100">
                            <i class="fas fa-check-circle me-2"></i>Lizenz validieren
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('licenses.create') }}" class="btn btn-warning btn-custom w-100">
                            <i class="fas fa-plus me-2"></i>Lizenz erstellen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-cogs fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">MVC Architektur</h5>
                        <p class="card-text">Moderne Laravel MVC-Struktur für beste Wartbarkeit und Skalierbarkeit.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Lizenz Validierung</h5>
                        <p class="card-text">Echtzeit-Validierung von Lizenzschlüsseln mit Statusüberprüfung.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-cloud fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Cloud Ready</h5>
                        <p class="card-text">Vorbereitet für die Migration zur Microservice-Architektur.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projekt Info -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="card feature-card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Über dieses Projekt</h4>
                        <p>Diese Anwendung demonstriert die Migration des JTL-Lizenzmanagements von einer monolithischen Architektur zu einer modernen Cloud-Microservice-Struktur.</p>
                        
                        <h6>Problemlösungen:</h6>
                        <ul>
                            <li><strong>Skalierbarkeit:</strong> Bessere Leistung bei Spitzenlasten</li>
                            <li><strong>Wartbarkeit:</strong> Einfache Implementierung neuer Lizenzmodelle</li>
                            <li><strong>Stabilität:</strong> Isolation von Fehlern in einzelnen Services</li>
                            <li><strong>Integration:</strong> Einfache Anbindung externer Systeme</li>
                        </ul>

                        <div class="mt-4">
                            <h6>Technologien:</h6>
                            <span class="badge bg-primary me-2">Laravel 10</span>
                            <span class="badge bg-success me-2">MySQL/SQLite</span>
                            <span class="badge bg-info me-2">Bootstrap 5</span>
                            <span class="badge bg-warning me-2">REST API</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card feature-card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-3">
                                <h4 class="text-primary">{{ \App\Models\License::count() }}</h4>
                                <p class="mb-0">Aktive Lizenzen</p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-success">{{ \App\Models\License::where('status', 'active')->count() }}</h4>
                                <p class="mb-0">Aktiv</p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-warning">{{ \App\Models\License::where('license_type', 'subscription')->count() }}</h4>
                                <p class="mb-0">Subscription</p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-info">{{ \App\Models\License::where('license_type', 'perpetual')->count() }}</h4>
                                <p class="mb-0">Perpetual</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">JTL Lizenzmanagement &copy; 2024 - Entwickelt für die Cloud-Migration</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>