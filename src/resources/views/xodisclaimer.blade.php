<x-xoform::layout>
  <link rel="stylesheet" href="{{asset('xoform_assets/css/continue.css')}}">
  <x-xoform::body>
    <x-xoform::img class="alcobrew-logo" src="{{asset('xoform_assets/img/logo.png')}}" alt="ALCOBREW"></x-xoform::img>
    <div class="heading">
      <h1 class="main-title">Buy the Golfer's Shot Luxury Travel Edition Pack &amp; Scan the QR Code inside the flap to WIN BIG !</h1>
      <p class="main-title-sub-text">You are just 2 Steps away from your assured REWARDS !</p>
    </div>
    <ul class="points">
      <li>
        <div class="bullet-points">1</div>
        <p>Fill Up Your Details &amp; the unique scratch code given above the QR CODE inside the flap.</p>
      </li>
      <li>
        <div class="bullet-points">2</div>
        <p>Spin The Wheel &amp; claim your reward.</p>
      </li>
    </ul>
    <a href="{{ url('form') }}" class="btn-fluid">Continue</a>
    <hr class="horizontal-divider">
    <div class="bottom-desc">
      <p>By pressing continue, you agree with the terms and condition.</p>
      <p>Every purchase of GOLFER'S SHOT Luxury Travel Edition Pack entitles you to <span style="color: red;"> 100 LOYALTY POINTS </span> as well which can be further redeemed against an assured mega prize.</p>
      <p>Offer is applicable in selected markets only for a limited period.</p> 
      <p>👉 <a href="{{ url('redemption') }}">Redeem your loyalty points here. </a></p>
      <p>This site is strictly meant for audiences above legal drinking age. We support responsible drinking.</p> 
    </div>
    
    <hr class="horizontal-divider">
    <x-xoform::powered term="{{ $terms_url }}"></x-xoform::powered>
  </x-xoform::body>
</x-xoform::layout>