@extends('dashboard-master')

@section('main')

    <div class="col-12 col-md-4 col-lg-4">
        <div class="card">
            <div class="card-status bg-warning"></div>
            <div class="card-header">
                <h3 class="card-title">Avertissement</h3>
            </div>
            <div class="card-body">
                <p>
                    Cette plateforme est encore en dévelopement et n'est pas encore opérationnelle pour une utilisation
                    porfessionnelle. De nombreuses fontionnalités n'ont pas encore été intégrées et le seront par la
                    suite. Pour plus d'information, n'hésitez pas à contacter l'administrateur.
                </p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Récemment</h3>
            </div>
            <div class="card-body">
                <h4>
                    <span class="tag tag-primary">unreleased</span>
                    {{--<span class="text-muted small">2019-0*-**</span>--}}
                </h4>
                {{--<p class="text-info">...</p>--}}
                <h5>Ajouts</h5>
                <ul>
                    <li>Ajouter des étudiants dans les classes</li>
                    <li>Afficher une classe</li>
                    <li>Modifier un cours</li>
                    <li>Réinitialisation du mot de passe</li>
                </ul>
                {{--<h5>Changements</h5>--}}
                {{--<ul>--}}
                {{--</ul>--}}
                {{--<h5>Corrections</h5>--}}
                {{--<ul>--}}
                {{--</ul>--}}
            </div>
            <div class="card-body">
                <h4>
                    <span class="tag tag-primary">0.2</span>
                    <span class="text-muted small">2019-05-21</span>
                </h4>
                <p class="text-info">Corrections suite à la version v0.1 et petits ajouts</p>
                <h5>Ajouts</h5>
                <ul>
                    <li>Ajout de la possibilité de modifier les étudiants et les parents</li>
                </ul>
                <h5>Changements</h5>
                <ul>
                    <li>Les cours sont maintenant accessibles depuis la page de gestion des classes</li>
                    <li>
                        Les étudiants sont accessibles depuis le menu et les parents depuis la page de gestion
                        des étudiants
                    </li>
                </ul>
                <h5>Corrections</h5>
                <ul>
                    <li>Amélioration de certaines parties sur mobile</li>
                    <li>Mauvais nom de colonne dans la base de données</li>
                    <li>Affinage de la commande de création des utilisateurs</li>
                    <li>Dépendances manquantes</li>
                </ul>
            </div>
            <div class="card-body">
                <h4>
                    <span class="tag tag-primary">0.1</span>
                    <span class="text-muted small">2019-05-19</span>
                </h4>
                <p class="text-info">Publication d'une première version du service !</p>
                <h5>Fonctionnalités</h5>
                <ul>
                    <li>Ajout de classe</li>
                    <li>Ajout de cours</li>
                    <li>Ajout d'administrateurs et enseignants.es</li>
                    <li>Ajout de parents et d'étudiants (enfants)</li>
                    <li>Organisation des parents et enfants en <i>Familles.</i></li>
                </ul>
            </div>
        </div>
    </div>

@endsection