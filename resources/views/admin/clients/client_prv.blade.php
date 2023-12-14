@extends('admin.layouts.app')
@section('content')
<!-- table start -->
<!-- table start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-md-12 col-xl-12">
            <div class="bg-light rounded h-100">
                <div class="">
                    <div class="tabstable-top">
                        <div class="tabstable-top-tab-bar">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Infos</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">Documents</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Projets financés</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="tabs-hd-top-ico">
                                    <h5>Infos</h5>
                                    <button id="myBtn" class="btn btn-sm btn-primary view-client-able-btn" href="">
                                        <img class="" src="{{asset('img/pencil.svg')}}" alt=""></button>
                                </div>

                                <h5 class="table-top-headeing">coordonnées de la société</h5>
                                <div class="table-responsive">
                                    <table class="table clients-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Société</th>
                                                <th scope="col">SIRET</th>
                                                <th scope="col">Adresse</th>
                                                <th scope="col">Capital</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ABCD SAS</td>
                                                <td>Pierre Dupont</td>
                                                <td>BTP</td>
                                                <td>Paris</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <h5 class="table-top-headeing">informations de contact</h5>
                                <div class="table-responsive">
                                    <table class="table clients-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nom</th>
                                                <th scope="col">Prénom</th>
                                                <th scope="col">Civilité</th>
                                                <th scope="col">Téléphone</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Tutoiement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Pierre</td>
                                                <td>Dupont</td>
                                                <td>Monsieur</td>
                                                <td>+33 1 23 45 67 89</td>
                                                <td>example@gmail.com</td>
                                                <td>Vous</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="tabs-hd-top-ico">
                                    <h5>Documents</h5>
                                    <button class="add-client-bnt" id="myBtn"><span>+</span> Ajouter un
                                        document</button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table clients-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Document</th>
                                                <th scope="col">Version</th>
                                                <th scope="col">Uploadé le</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>CNI du Gérant</td>
                                                <td>2023</td>
                                                <td>15/01/2023</td>
                                                <td class="action-btns-table">
                                                    <a class="btn btn-sm btn-primary view-client-able-btn btn-table-download"
                                                        href="">
                                                        <img class="" src="{{asset('img/arrow-down.svg')}}" alt=""> Télécharger</a>
                                                    <a class="btn btn-sm btn-primary view-client-able-btn btn-table-upload"
                                                        href="">
                                                        <img class="" src="{{asset('img/arrow-down-up.svg')}}" alt=""> Upload
                                                        <span>(up to 25 mb)</span></a>
                                                    <a class="btn btn-sm btn-primary view-client-able-btn delete-btn-sm"
                                                        href="">
                                                        <img class="" src="{{asset('img/trush-square.svg')}}" alt=""></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Rapport sur le profil du client</td>
                                                <td>2022</td>
                                                <td>23/04/2023</td>
                                                <td class="action-btns-table">
                                                    <a class="btn btn-sm btn-primary view-client-able-btn btn-table-download"
                                                        href="">
                                                        <img class="" src="{{asset('img/arrow-down.svg')}}" alt=""> Télécharger</a>
                                                    <a class="btn btn-sm btn-primary view-client-able-btn btn-table-upload"
                                                        href="">
                                                        <img class="" src="{{asset('img/arrow-down-up.svg')}}" alt=""> Upload
                                                        <span>(up to 25 mb)</span></a>
                                                    <a class="btn btn-sm btn-primary view-client-able-btn delete-btn-sm"
                                                        href="">
                                                        <img class="" src="{{asset('img/trush-square.svg')}}" alt=""></a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Dossier de proposition de prêt</td>
                                                <td>2020</td>
                                                <td>24/04/2023</td>
                                                <td class="action-btns-table">
                                                    <a class="btn btn-sm btn-primary view-client-able-btn btn-table-download"
                                                        href="">
                                                        <img class="" src="{{asset('img/arrow-down.svg')}}" alt=""> Télécharger</a>
                                                    <a class="btn btn-sm btn-primary view-client-able-btn btn-table-upload"
                                                        href="">
                                                        <img class="" src="{{asset('img/arrow-down-up.svg')}}" alt=""> Upload
                                                        <span>(up to 25 mb)</span></a>
                                                    <a class="btn btn-sm btn-primary view-client-able-btn delete-btn-sm"
                                                        href="">
                                                        <img class="" src="{{asset('img/trush-square.svg')}}" alt=""></a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="tabs-hd-top-ico">
                                    <h5>Projets financés</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table clients-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Projet</th>
                                                <th scope="col">Montant</th>
                                                <th scope="col">Fournisseur</th>
                                                <th scope="col">Date de livraison</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Camion benne</td>
                                                <td>20.000€</td>
                                                <td>BTPMax</td>
                                                <td>20/01/2023</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- table End -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close-modal"><img src="{{asset('img/cros-btn.svg')}}" /></span>
        <div class="model-content-box">
            <h6>Modifier le client</h6>
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
                        <img src="{{asset('img/cloud-change.svg')}}" />
                        <p>Synchroniser avec Ellisphere</p>
                        <img src="{{asset('img/logo-elip.png')}}" />
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