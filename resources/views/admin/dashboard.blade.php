@extends('admin.layouts.app')
@section('content')
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-4">
                        <div class="box-stats bg-light rounded d-flex align-items-start justify-content-between p-4">
                            <div class="">
                                <h6 class="text-start">42</h6>
                                <p class="">Prospects</p>
                            </div>
                            <img src="{{asset('img/user-square.svg')}}" class="img" />
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="box-stats bg-light rounded d-flex align-items-start justify-content-between p-4">
                            <div class="">
                                <h6 class="">285 800 €</h6>
                                <p class="">Financés ce mois-ci</p>
                            </div>
                            <img src="{{asset('img/empty-wallet-tick.svg')}}" class="img" />
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <div class="box-stats bg-light rounded d-flex align-items-start justify-content-between p-4">
                            <div class="">
                                <h6 class="text-start">25 700 €</h6>
                                <p class="">De commission ce mois-ci</p>
                            </div>
                            <img src="{{asset('img/percentage-square.svg')}}" class="img" />
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Widgets Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded notification-bar-dash">
                            <div class="p-4 d-flex align-items-center justify-content-between">
                                <h6 class="mb-0">Notifications</h6>
                              
                            </div>

                            <div class="notification-scroll-area">
                            <p class="seprator-rem px-4">AUJOURD'HUI</p>
                            <div class="px-4 d-flex align-items-center border-top py-3 active-notification">
                                <div class="w-100 notification-block">
                                    <div class="d-flex w-100 flex-column justify-content-between">
                                        <h6 class="mb-0">Tâche achevée : Le processus de vérification du client VWX est terminé. Mettez le client à jour en conséquence.</h6>
                                        <small>11:16 HEURES</small>
                                    </div>
                                    <a href="#"><img src="{{asset('img/delete.svg')}}" class="img" /></a>
                                </div>
                            </div>

                            <div class="px-4 d-flex align-items-center border-top py-3">
                                <div class="w-100 notification-block">
                                    <div class="d-flex w-100 flex-column justify-content-between">
                                        <h6 class="mb-0">Réunion prévue avec le client GHI demain à 14 heures. Préparer les documents nécessaires et l'ordre du jour.</h6>
                                        <small>9:45 HEURES</small>
                                    </div>
                                    <a href="#"><img src="{{asset('img/delete.svg')}}" class="img" /></a>
                                </div>
                            </div>

                            <div class="px-4 d-flex align-items-center border-top py-3">
                                <div class="w-100 notification-block">
                                    <div class="d-flex w-100 flex-column justify-content-between">
                                        <h6 class="mb-0">La demande du client DEF nécessite des documents supplémentaires.</h6>
                                        <small>8:12 HEURES</small>
                                    </div>
                                    <a href="#"><img src="{{asset('img/delete.svg')}}" class="img" /></a>
                                </div>
                            </div>

                            <div class="px-4 d-flex align-items-center border-top py-3">
                                <div class="w-100 notification-block">
                                    <div class="d-flex w-100 flex-column justify-content-between">
                                        <h6 class="mb-0">La demande du client DEF nécessite des documents supplémentaires.</h6>
                                        <small>8:12 HEURES</small>
                                    </div>
                                    <a href="#"><img src="{{asset('img/delete.svg')}}" class="img" /></a>
                                </div>
                            </div>

                            <div class="px-4 d-flex align-items-center border-top py-3">
                                <div class="w-100 notification-block">
                                    <div class="d-flex w-100 flex-column justify-content-between">
                                        <h6 class="mb-0">La demande du client DEF nécessite des documents supplémentaires.</h6>
                                        <small>8:12 HEURES</small>
                                    </div>
                                    <a href="#"><img src="{{asset('img/delete.svg')}}" class="img" /></a>
                                </div>
                            </div>
                        </div>
                            
                            
                            
                        </div>
                    </div>
                  
                </div>
            </div>
            <!-- Widgets End -->
@endsection