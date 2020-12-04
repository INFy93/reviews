@extends('layouts.app')

@section('content')

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#v1">Vue JS 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#characteristics">Характеристики</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#opinion">Отзывы</a>
        </li>
    </ul>
    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="v1">
            <h2 class="h4 mb-3">Example Component</h2>
            <br>
            <example-component></example-component>
        </div>
        <div class="tab-pane fade" id="characteristics">
            <h2 class="h4 mb-3">Характеристики товара</h2>
            <br>
            <prop-component :urldata="{{ json_encode($url_data) }}"></prop-component>
            <div class="tab-pane fade" id="opinion">
                <h2 class="h4 mb-3">Отзывы</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt accusantium sapiente animi suscipit magnam
                    ex quasi nihil quas voluptas! Eius minus incidunt iure deserunt dolor praesentium. Ullam aperiam optio
                    omnis!</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, cupiditate! Aspernatur accusamus dolores
                    tenetur iure rerum ut quibusdam nisi aliquam facilis impedit. Sed amet nemo, veniam in placeat eveniet
                    illo!</p>
            </div>
        </div>
    </div>
@endsection
