@extends(template().'layout.master')

@section('content')
<section class="page-banner" style="background-image: url({{ getFile('breadcrumbs', $general->breadcrumbs, true) }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="title text-white">{{__($pageTitle)}}</h2>
                <ul class="page-breadcrumb justify-content-center mt-2">
                    <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li>{{__($pageTitle)}}</li>
                </ul>
            </div>
        </div>
    </div>
</section>


    @if ($page->sections != null)
        @foreach ($page->sections as $sections)
           

            @include(template().'sections.' . $sections)
        @endforeach
    @endif



@endsection
