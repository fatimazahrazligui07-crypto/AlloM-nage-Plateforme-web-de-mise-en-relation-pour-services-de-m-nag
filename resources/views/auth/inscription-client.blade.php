<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Client - Allo Ménage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    
    <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8 m-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mb-4">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Allo Ménage</h2>
            <p class="text-gray-600 mt-2">Créer votre compte</p>
        </div>

        <!-- Debug Info -->
        <div class="mb-4 p-3 bg-green-100 border border-green-400 rounded text-sm">
            <strong>✅ Version Blade - Villes disponibles: {{ $villes->count() }}</strong><br>
            @foreach($villes as $ville)
                - {{ $ville->id }}: {{ $ville->nom_ville }}<br>
            @endforeach
        </div>

        <!-- Erreurs -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('inscription.client.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Nom -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input
                    name="nom"
                    type="text"
                    required
                    placeholder="Votre nom"
                    value="{{ old('nom') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <!-- Prénom -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                <input
                    name="prenom"
                    type="text"
                    required
                    placeholder="Votre prénom"
                    value="{{ old('prenom') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    name="email"
                    type="email"
                    required
                    placeholder="exemple@mail.com"
                    value="{{ old('email') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <!-- Téléphone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <input
                    name="num_telephone"
                    type="tel"
                    required
                    placeholder="06 12 34 56 78"
                    value="{{ old('num_telephone') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <!-- Ville -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                <select
                    id="ville_id"
                    name="ville_id"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white"
                >
                    <option value="">Sélectionnez une ville</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville->id }}" {{ old('ville_id') == $ville->id ? 'selected' : '' }}>
                            {{ $ville->nom_ville }}
                        </option>
                    @endforeach
                </select>
                <div class="text-xs text-gray-500 mt-1">
                    {{ $villes->count() }} ville(s) disponible(s)
                </div>
            </div>

            <!-- Quartier -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quartier</label>
                <select
                    id="quartier_id"
                    name="quartier_id"
                    required
                    disabled
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white disabled:bg-gray-100"
                >
                    <option value="">Sélectionnez un quartier</option>
                </select>
                <div class="text-xs text-gray-500 mt-1">
                    <span id="quartier-count">0</span> quartier(s) disponible(s)
                </div>
            </div>

            <!-- Mot de passe -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input
                    name="motdepasse"
                    type="password"
                    required
                    placeholder="••••••••"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <!-- Confirmer mot de passe -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer mot de passe</label>
                <input
                    name="motdepasse_confirmation"
                    type="password"
                    required
                    placeholder="••••••••"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <!-- Bouton S'inscrire -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium"
            >
                S'inscrire
            </button>

            <!-- Lien vers connexion -->
            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    Vous avez déjà un compte ? 
                    <a href="/login" class="text-blue-600 hover:text-blue-500 font-medium">
                        Se connecter
                    </a>
                </p>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const villeSelect = document.getElementById('ville_id');
            const quartierSelect = document.getElementById('quartier_id');
            const quartierCount = document.getElementById('quartier-count');
            
            console.log('Script chargé');
            console.log('Ville select:', villeSelect);
            console.log('Quartier select:', quartierSelect);
            
            villeSelect.addEventListener('change', function() {
                const villeId = this.value;
                console.log('Ville sélectionnée:', villeId);
                
                if (villeId) {
                    quartierSelect.disabled = false;
                    quartierSelect.innerHTML = '<option value="">Chargement des quartiers...</option>';
                    
                    fetch(`/get-quartiers/${villeId}`)
                        .then(response => {
                            console.log('Réponse reçue:', response);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Quartiers reçus:', data);
                            
                            quartierSelect.innerHTML = '<option value="">Sélectionnez un quartier</option>';
                            
                            data.forEach(quartier => {
                                const option = document.createElement('option');
                                option.value = quartier.id;
                                option.textContent = quartier.nom_quartier;
                                quartierSelect.appendChild(option);
                            });
                            
                            quartierCount.textContent = data.length;
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            quartierSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        });
                } else {
                    quartierSelect.disabled = true;
                    quartierSelect.innerHTML = '<option value="">Sélectionnez un quartier</option>';
                    quartierCount.textContent = '0';
                }
            });
        });
    </script>
</body>
</html>