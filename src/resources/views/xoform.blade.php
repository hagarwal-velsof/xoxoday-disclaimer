<x-xoform::layout>
  {!! RecaptchaV3::initJs() !!}

  <link rel="stylesheet" href="{{asset('xoform_assets/css/one_last_step.css')}}">

  <x-xoform::body>
    <div class="heading">
      <h1 class="main-title">One last step!</h1>
      <p class="main-title-sub-text">Fill in the form below to receive your reward</p>
    </div>

    @foreach ($errors->all() as $error)
    <div class="alert alert-danger">@if($error =='validation.recaptchav3')
      <span>Recaptcha validation failed. Please reload the page.</spam>
      @else
      {{ $error }}
      @endif
    </div>
    @endforeach

    <x-xoform::form action="{{ url('/form') }}" id="sample" method="POST">
    @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" id="name" name='name' tabindex="1" class="form-control" placeholder="Enter your full name" data-rule-firstname="true" value="{{ old('name') }}">
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Phone number</label>
        <div class="country-code">
          <input type="text" name='' class="form-control select-code" readonly="readonly" value="IN +91" style="background: #D3D3D3;">
          <input type="tel" id="mobile" name='mobile' tabindex="2" class="form-control" placeholder="Enter phone number" data-rule-mobile="true" value="{{ old('mobile') }}">
        </div>
        <label id="mobile-error" class="error" for="mobile"></label>
      </div>
      <div class="mb-3" style="display: none;">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" id="email" name='email' tabindex="3" class="form-control" placeholder="Enter your email address (Optional)" data-rule-email="true" value="{{ old('email') }}">
      </div>
      <div class="mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text" id="city" name='city' class="form-control" tabindex="4" placeholder="Enter your city (Optional)" data-rule-optionalcharonly="true" value="{{ old('city') }}">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Unique Code</label>
        <input type="text" id="code" name='code' class="form-control" tabindex="5" placeholder="EG: X5644698VG565" data-rule-mandatory="true" value="{{ old('code') }}">
        <small class="small-text">You will find this unique code on the inside flap of mono carton</small>
      </div>

      {!! RecaptchaV3::field('form') !!}

      <div>
        <x-xoform::buttonPrimary type="button" id="submit" class="" value='Submit' style=""><i class="fa fa-spinner fa-spin"></i>&nbsp;Submit</x-buttonPrimary>
      </div>
    </x-xoform::form>

    <div style="margin-top:20px">
      <x-xoform::powered term="{{ $terms_url }}"></x-powered>
    </div>

    <script>
      $(document).ready(function() {
        $(".fa-spin").hide();
        $("#submit").prop("disabled", false);
      });


      $('#sample').submit(function() {
        $("#submit").prop("disabled", true);
        $(".fa-spin").show();
      });
    </script>
  </x-xoform::body>
</x-xoform::layout>