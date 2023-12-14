@extends('admin.layouts.app')
@section('content')
    <!-- table start -->
    <div class="container-fluid pt-4 px-4 custom_container_section">
        <div class="row g-4">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <div class="bg-light rounded h-100">
                    <div class="table-top-bar">
                        <form class="d-none d-md-flex">
                            <input class="form-control border-0" type="search" placeholder="Rechercher">
                            <button class="search-btn"><img src="{{ asset('img/search.svg') }}" /></button>
                        </form>

                        <button class="add-client-bnt" id="myBtn"><span>+</span> Créer un client</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table clients-table">
                            <thead>
                                <tr>
                                    <th scope="col">Société</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Activité</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ABCD SAS</td>
                                    <td>Pierre Dupont</td>
                                    <td>BTP</td>
                                    <td>Paris</td>
                                    <td><a class="btn btn-sm btn-primary view-client-able-btn"
                                            href="{{ route('client.clients_prv') }}">
                                            <img class="" src="{{ asset('img/eye.svg') }}" alt="">En savoir
                                            plus</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Finances Parisienne</td>
                                    <td>François Leclerc</td>
                                    <td>Informatique et Services</td>
                                    <td>Lyon-sur-Seine</td>
                                    <td><a class="btn btn-sm btn-primary view-client-able-btn"
                                            href="{{ route('client.clients_prv') }}">
                                            <img class="" src="{{ asset('img/eye.svg') }}" alt="">En savoir
                                            plus</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>EBS</td>
                                    <td>Sophie Martin</td>
                                    <td>Commerce de Détail</td>
                                    <td>Toulousaine</td>
                                    <td><a class="btn btn-sm btn-primary view-client-able-btn"
                                            href="{{ route('client.clients_prv') }}">
                                            <img class="" src="{{ asset('img/eye.svg') }}" alt="">En savoir
                                            plus</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>ABCD SAS</td>
                                    <td>Pierre Dupont</td>
                                    <td>BTP</td>
                                    <td>Paris</td>
                                    <td><a class="btn btn-sm btn-primary view-client-able-btn"
                                            href="{{ route('client.clients_prv') }}">
                                            <img class="" src="{{ asset('img/eye.svg') }}" alt="">En savoir
                                            plus</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Finances Parisienne</td>
                                    <td>François Leclerc</td>
                                    <td>Informatique et Services</td>
                                    <td>Lyon-sur-Seine</td>
                                    <td><a class="btn btn-sm btn-primary view-client-able-btn"
                                            href="{{ route('client.clients_prv') }}">
                                            <img class="" src="{{ asset('img/eye.svg') }}" alt="">En savoir
                                            plus</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>EBS</td>
                                    <td>Sophie Martin</td>
                                    <td>Commerce de Détail</td>
                                    <td>Toulousaine</td>
                                    <td><a class="btn btn-sm btn-primary view-client-able-btn"
                                            href="{{ route('client.clients_prv') }}">
                                            <img class="" src="{{ asset('img/eye.svg') }}" alt="">En savoir
                                            plus</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>ABCD SAS</td>
                                    <td>Pierre Dupont</td>
                                    <td>BTP</td>
                                    <td>Paris</td>
                                    <td><a class="btn btn-sm btn-primary view-client-able-btn"
                                            href="{{ route('client.clients_prv') }}">
                                            <img class="" src="{{ asset('img/eye.svg') }}" alt="">En savoir
                                            plus</a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <nav aria-label="Page navigation pagination example">
                            <ul class="pagination">
                                <li class="page-item page-item-prv">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><img src="{{ asset('img/next.svg') }}" /></span>
                                    </a>
                                </li>
                                <li class="page-item page-item-nxt">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true"><img src="{{ asset('img/next.svg') }}" /></span>
                                    </a>
                                </li>


                                <li class="page-item page-item-count">1</li>
                                <p class="page-item-count">sur</p>
                                <li class="page-item page-item-count">4</li>


                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- table End -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close-modal"><img src="{{ asset('img/cros-btn.svg') }}" /></span>
            <div class="model-content-box">
                <h6>Créer un client</h6>
                <form>

                    <div class="form-modal-content-wrppaer">

                        <div class="form-modal-left">
                            <h5 class="form-blocks-top-head">coordonnées de la société</h5>
                            <div class="from-row-wrapper">
                                <div class="from-row-block">
                                    <label>Société</label>
                                    <input type="text" class="form-control" placeholder="ABCD SAS" />
                                </div>

                                <div class="from-row-block">
                                    <label>SIRET</label>
                                    <input type="text" class="form-control" placeholder=" 123 456 789 00012" />
                                </div>
                            </div>

                            <div class="from-row-wrapper">
                                <div class="from-row-block">
                                    <label>Adresse</label>
                                    <input type="text" class="form-control" placeholder="20 Boulevard de la Plage" />
                                </div>

                                <div class="from-row-block">
                                    <label>Capital</label>
                                    <input type="text" class="form-control" placeholder="100,000 €" />
                                </div>
                            </div>

                            <h5 class="form-blocks-top-head">informations de contact</h5>
                            <div class="from-row-wrapper">
                                <div class="from-row-block">
                                    <label>Nom</label>
                                    <input type="text" class="form-control" placeholder="Pierre" />
                                </div>

                                <div class="from-row-block">
                                    <label>Prénom</label>
                                    <input type="text" class="form-control" placeholder="Dupont" />
                                </div>

                                <div class="from-row-block">
                                    <label>Civilité</label>
                                    <input type="text" class="form-control" placeholder="Monsieur" />
                                </div>
                            </div>

                            <div class="from-row-wrapper">
                                <div class="from-row-block">
                                    <label>Téléphone</label>
                                    <input type="text" class="form-control" placeholder="+33 1 23 45 67 89" />
                                </div>

                                <div class="from-row-block">
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="example@gmail.com" />
                                </div>

                                <div class="from-row-block">
                                    <label>Tutoiement</label>
                                    <input type="text" class="form-control" placeholder="Vous" />
                                </div>
                            </div>
                        </div>

                        <div class="form-modal-right">
                            <img src="{{ asset('img/cloud-change.svg') }}" />
                            <p>Synchroniser avec Ellisphere</p>
                            <img src="{{ asset('img/logo-elip.png') }}" />
                        </div>

                    </div>


                    <div class="from-row-wrapper">
                        <button type="submit" class="btn-primary-gold">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
