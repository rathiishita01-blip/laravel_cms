@extends('layout.frontend')

@section('content')

<style>
    .errorimage {
        max-width: 50%;
        height: auto;
        margin-bottom: 20px;
    }

    @media(max-width:767px){
        .errorimage {
            max-width: 80%;
        }
    }

</style>

{{-- 404 Section --}}
<section class="contactsection">
    <div class="container">
        <div class="row justify-content-center text-center">

            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="form-block">

                    <div class="section-heading">
                        <img src="{{ asset('/assets/images/404.png') }}" alt="404" class="errorimage">
                    </div>

                    <div class="desc pb-4">
                        <p>
                            The page you are looking for does not exist,
                            has been moved, or is temporarily unavailable.
                        </p>
                    </div>

                    <a href="{{ url('/') }}" class="primary-btn">
                        Back to Home
                        <i class="ri-arrow-right-up-line"></i>
                        <i class="ri-arrow-right-line"></i>
                    </a>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection