<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agus & Joy Intimate Wedding</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('simplycountdown/dist/themes/dark.css')}}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <style>
    :root {
    --pink: #f14e95;
    --bg: #0a0a0a;
    --shadow: 0 2px 2px rgb(0, 0, 0, 0.5);
    }
    body {
      font-family: 'Georgia', serif;
      background-color: #fdfdfd;
      margin: 0;
      overflow: hidden; /* kunci scroll sebelum cover hilang */
    }
    h4{
      font-size: 2rem;
    }
    section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 60px 20px;
    }

    /* COVER */
    #cover {
      position: fixed;
      inset: 0;
      z-index: 9999;
      /* background: url(../inv/img/gpt.png) 50% 20% /cover no-repeat; 40% 20% atau center untuk mengatur posisi gambar */
      background: url('{{ asset($backgroundImages) ?? asset('inv/img/tushar-ranjan-GqpGd6NtUoI-unsplash.jpg') }}')
                  50% 20% / cover no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      transition: transform 1s ease, opacity 1s ease;
    }
    #cover::after {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
    }
    #cover .content {
      position: relative;
      z-index: 2;
    }
    #cover.hidden {
      transform: translateY(-100%);
      opacity: 0;
      pointer-events: none;
    }
    #cover h1,
    #cover h4 {
      text-shadow: var(--shadow);
    }
    #cover h1 {/*headline*/
      font-family: "Lavishly Yours", cursive;
      font-size: 4rem;
    }
    #cover h4 {/*judul*/
      font-size: 2rem;
    }
    #cover a {
        color: white;
        background-color: var(--bg);
    }
    #cover button:hover {
        background-color: var(--pink);
        color: white;
    }
    
    /* General Section Style */
    section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 4rem 2rem;
    }

    /*HEAD*/
    #head { 
      /* background: #2b7ed0;  */
      /* position: relative; */
      min-height: 100vh;          /* selalu penuh 1 layar */
      width: 100%;      
      display: flex;
      justify-content: space-between; /* atur atas & bawah */
      padding: 80px 20px; /* beri jarak biar tidak mepet layar */
      align-items: center;
      /* justify-content: center; */
      text-align: center;
      color: white;
      /* background: url('../inv/img/gpt1.png')  center / cover no-repeat; */
      background: url('{{ asset($backgroundImages) ?? asset('inv/img/gpt1.png') }}')
                  center / cover no-repeat;
      background-attachment: fixed; /* 🎯 ini yang bikin statik */
      background-position: center;
    }
    #head h1 {
      font-family: "Lavishly Yours", cursive;
      font-size: 4rem;
    }
    #head .head-top {
      margin-top: 10vh; /* geser sedikit dari atas */
    }
    #head .head-bottom {
      margin-bottom: 10vh; /* geser sedikit dari bawah */
    }

    /*INFO*/
    #info { 
      /* background: #000000; */
      position: relative;
      min-height: 100vh;          /* selalu penuh 1 layar */
      width: 100%;      
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      background: url('{{ asset($backgroundImages) ?? asset('inv/img/tushar-ranjan-GqpGd6NtUoI-unsplash.jpg') }}')
                  center / cover no-repeat;
      background-attachment: fixed; /* 🎯 ini yang bikin statik */
      background-position: center;
      opacity: 0.8;
    }
    #info .couple {
      margin-top: 20px !important;
      margin-bottom: 20px !important;
    }
    #info .couple h3 {
      font-family: "Lavishly Yours", cursive;
      font-size: 2rem;
      color: var(--pink);
    }
    #info .couple img {
      max-width: 100%;
    }

    /*GALLERY*/
    /* #gallery { background: #24be61; } */
    #gallery {
      max-width: 1200px;   /* batasi lebar galeri */
      margin: 0 auto;      /* posisikan ke tengah */
      padding: 50px;
      border-radius: 20px;
    }
    #gallery h2 {
      font-size: 3rem;
      font-family: "Lavishly Yours", cursive;
    }
    #gallery .gallery-item {
      position: relative;
      overflow: hidden;
      border-radius: 15px;
      cursor: pointer;
      margin-bottom: 15px; /* biar ada jarak antar row */
    }
    #gallery .gallery-item img {
      width: 100%;
      /*height: 250px;       /* atur tinggi seragam */
      object-fit: cover;   /* crop rapi */
      transition: transform .4s ease;
    }
    #gallery .gallery-item:hover img {
      transform: scale(1.2);
      filter: brightness(0.8);
    }
    #gallery .overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: rgba(0,0,0,0.5);
      color: #fff;
      padding: 10px;
      text-align: center;
      transform: translateY(100%);
      transition: transform .3s ease;
    }
    #gallery .gallery-item:hover .overlay {
      transform: translateY(0);
    }

    /* Location */
    #location { 
      position: relative;
      min-height: 100vh;          /* selalu penuh 1 layar */
      width: 100%;      
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      background: url('{{ asset($backgroundImages) ?? asset('inv/img/gpt.png') }}')
                  center / cover no-repeat;
      background-attachment: fixed; /* 🎯 ini yang bikin statik */
      background-position: center;
    }
    #location h2 {
      font-size: 3rem;
      font-family: "Lavishly Yours", cursive;
    }
      
    /* Story */
    #story { 
      padding-top: 8rem;
      padding-bottom: 8rem;
      position: relative;
      min-height: 100vh;          selalu penuh 1 layar
      /* max-height: 90vh;          selalu penuh 1 layar */
      width: 100%;      
      /* display: flex; */
      /* align-items: center; */
      /* justify-content: center; */
      /* text-align: center; */
      color: white;
      background: rgba(0,0,0,0.5);
      background: url('{{ asset($backgroundImages) ?? asset('inv/img/gpt.png') }}')
                  center / cover no-repeat;
      background-attachment: fixed; 🎯 ini yang bikin statik
      /* background-position: center; */
    }
    #story h2 {
      font-size: 3rem;
      font-family: "Lavishly Yours", cursive;
      color: var(--pink)
    }
    #story span {
      text-transform: uppercase;
      color: #666;
      font-size: 0.9rem;
      letter-spacing: 1px;
      display: block;
      margin-bottom: 1rem;
    }
    #story p {
      font-size: 0.7rem;
      font-weight: 1.6;
      color: #333;
    }
    
    #story .timeline {
        list-style-type: none;
        position: relative;
        padding: 2rem 0;
        /* margin-top: 1rem; */
        margin-top: 0;
        margin-bottom: 0;
    }

    #story .timeline::before {
        content: '';
        top: -10px;
        bottom: -10px;
        position: absolute;
        width: 1px;
        background-color: #ccc;
        left: 50%;

    }

    #story .timeline li {
        position: relative;
        margin-bottom: 1rem;
    }

    #story .timeline li::before,
    #story .timeline li::after {
        content: '';
        display: table;
        clear: both;
    }

    #story .timeline li::after {
        clear: both;
    }

    #story .timeline li .timeline-image {
        width: 160px;
        height: 160px;
        background-color: #ccc;
        position: absolute;
        left: 50%;
        border-radius: 50%;
        transform: translateX(-50%);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    #story .timeline li .timeline-panel {
        width: 35%;
        float: left;
        border: 1px solid #ccc;
        background-color: white;
        padding: 2rem;
        position: relative;
        border-radius: 8px;

    }

    #story .timeline li .timeline-panel::before {
        content: '';
        display: inline-block;
        position: absolute;
        top: 80px;
        width: 20px;
        height: 20px;
        background-color: white;
        border-top: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-bottom: 1px solid transparent;
        border-left: 1px solid transparent;
        right: -10px;
        transform: rotate(45deg);
        /* z-index: -1; */

    }

    #story .timeline li.timeline-inverted .timeline-panel {
        width: 35%;
        float: right;
        border: 1px solid #ccc;
        padding: 2rem;
        position: relative;
        border-radius: 8px;

    }

    #story .timeline li.timeline-inverted .timeline-panel::before {
        content: '';
        display: inline-block;
        position: absolute;
        top: 20px;
        width: 20px;
        height: 20px;
        background-color: white;
        border-top: 1px solid transparent;
        border-right: 1px solid transparent;
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
        left: -10px;
        transform: rotate(45deg);
        /* z-index: -1; */

    }

    /* Reservasi */
    #reservation {
      display: flex;
      justify-content: center;
      padding: 50px 20px;
      background: #f5f5f5;
    }

    #reservation .invitation-card {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 20px;
      max-width: 800px;
      width: 100%;
      padding: 30px;
      border-radius: 16px;
      background: linear-gradient(135deg, #1c1c1c, #2e2e2e); /* elegan gelap */
      color: #fff;
      box-shadow: 0 8px 24px rgba(0,0,0,0.4);
    }

    #reservation .card-left {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border-right: 2px dashed rgba(255,255,255,0.2);
      padding: 50px;
      padding-right: 70px
    }

    #reservation .card-left img {
      width: 250px;
      height: 250px;
      margin-bottom: 15px;
    }

    #reservation .card-left .code {
      font-size: 14px;
      letter-spacing: 1px;
      color: #ddd;
    }

    #reservation .card-right {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding-left: 20px;
    }

    #reservation .invite-header {
      font-size: 24px;
      margin-bottom: 15px;
      color: #ffd700; /* aksen emas elegan */
    }

    #reservation .invite-detail {
      margin: 5px 0;
      font-size: 16px;
      line-height: 1.5;
    }

    /* Gift */
    #gift .btn-pink {
      background-color: #e83e8c;
      color: #fff;
      border-radius: 10px;
      transition: 0.3s;
    }
    #gift .btn-pink:hover {
      background-color: #d63384;
      color: #fff;
    }
    #gift .btn-outline-pink {
      border: 2px solid #e83e8c;
      color: #e83e8c;
      border-radius: 10px;
      transition: 0.3s;
    }
    #gift .btn-outline-pink:hover {
      background-color: #e83e8c;
      color: #fff;
    }

    /* Animasi list pesan */
      #gift .messageList .card {
      border-left: 5px solid #e83e8c;
    }

    /* Efek animasi fade-in */
    #gift .fade-in {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.6s forwards;
    }
    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    @media(max-width: 1024px) {
      .profile-card {
          background: rgba(255, 255, 255, 0.2); /* transparan */
          backdrop-filter: blur(10px);          /* efek blur */
              -webkit-backdrop-filter: blur(10px); 
          border-radius: 12px;
          padding: 2rem;
          max-width: 100vh;
          margin: auto;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }
      .profile-card img {
          width: 100%;
          height: 100%;            /* isi penuh sesuai col */
          object-fit: cover;
          border-radius: 12px;
      }
      #gallery {
          max-width: 900px;
      }
      #story .timeline li .timeline-panel {
        width: 35%;
        float: left;
        border: 1px solid #ccc;
        background-color: white;
        padding: 1rem;
        position: relative;
        border-radius: 8px;
      }
      #story .timeline li.timeline-inverted .timeline-panel {
        width: 35%;
        float: right;
        border: 1px solid #ccc;
        padding: 1rem;
        position: relative;
        border-radius: 8px;

      }
    }
    @media(max-width: 768px) {
      .profile-card {
          background: rgba(255, 255, 255, 0.2); /* transparan */
          backdrop-filter: blur(10px);          /* efek blur */
              -webkit-backdrop-filter: blur(10px);  /* safari */
          border-radius: 12px;
          padding: 2rem;
          max-width: 700px;
          margin: auto;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }
      .profile-card img {
          width: 100%;
          height: 100%;            /* isi penuh sesuai col */
          object-fit: cover;
          border-radius: 12px;
      }
      #story .timeline::before {
          left: 60px;
      }

      #story .timeline li .timeline-image {
          left: 10px;
          margin-left: 45px;
          /* top: 16px; */
      }

      #story .timeline li .timeline-panel {
          width: calc(100% - 180px);
          float: right;
      }
      #story .timeline li .timeline-panel::before {
          background-color: white;
          border-top: 1px solid transparent;
          border-right: 1px solid transparent;
          border-bottom: 1px solid #ccc;
          border-left: 1px solid #ccc;
          left: -10px;
          transform: rotate(45deg);
      }
      #story .timeline li.timeline-inverted .timeline-panel {
          width: calc(100% - 180px);
          float: right;
      }
    }
    @media(max-width: 576px) {
      .profile-card {
          background: rgba(255, 255, 255, 0.2); /* transparan */
          backdrop-filter: blur(10px);          /* efek blur */
            -webkit-backdrop-filter: blur(10px);  /* safari */
          border-radius: 12px;
          padding: 2rem;
          max-width: 400px;
          margin: auto;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }
      .profile-card img {
          width: 100%;
          height: 100%;            /* isi penuh sesuai col */
          object-fit: cover;
          border-radius: 12px;
      }
      #story .timeline li .timeline-image {
          left: 10px;
          margin-left: 45px;
          /* top: 16px; */
          border-radius: 30px;
          width: 120px;
          height: 120px;
      }
      #story .timeline::before {
        content: '';
        top: -10px;
        bottom: -10px;
      }
      #story .timeline li .timeline-panel {
          width: calc(100% - 130px);
          float: right;
          padding:10px;
      }
      #story .timeline li.timeline-inverted .timeline-panel {
          width: calc(100% - 130px);
          float: right;
          padding: 10px;
      }
    }
   
    /* Fade-in base */
    .fade-content {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 1s ease, transform 1s ease;
    }

    .visible.fade-content {
      opacity: 1;
      transform: translateY(0);
    }

    /* Delay untuk animasi berurutan */
    .fade-content:nth-child(1) { transition-delay: 0.5s; }
    .fade-content:nth-child(2) { transition-delay: 0.2s; }
    .fade-content:nth-child(3) { transition-delay: 0.2s; }
    .fade-content:nth-child(4) { transition-delay: 0.2s; }
    .fade-content:nth-child(5) { transition-delay: 0.2s; }
    .fade-content:nth-child(6) { transition-delay: 0.2s; }
    .fade-content:nth-child(7) { transition-delay: 0.2s; }
    .fade-content:nth-child(8) { transition-delay: 0.2s; }
    .fade-content:nth-child(9) { transition-delay: 0.2s; }
    .fade-content:nth-child(10) { transition-delay: 0.2s; }
    .fade-content:nth-child(11) { transition-delay: 0.2s; }
    .fade-content:nth-child(12) { transition-delay: 0.2s; }
    .fade-content:nth-child(13) { transition-delay: 0.2s; }
    .fade-content:nth-child(14) { transition-delay: 0.2s; }
    .fade-content:nth-child(15) { transition-delay: 0.2s; }
    .fade-content:nth-child(16) { transition-delay: 0.2s; }
    .fade-content:nth-child(17) { transition-delay: 0.2s; }
  </style>
</head>

<body>

  <!-- COVER -->
  <section id="cover">
    <div class="text-center content">
      <h2 class="fw-light">Wedding Invitation</h2>
      <h1 class="fw-bold display-3">{{ $couple->groom_name ?? 'Groom' }} & {{ $couple->bride_name ?? 'Bride' }}</h1>
      <h2 class="fw-light ">Dear Our Honored Guest <br> {{ $guestName ?? 'Guest' }}</h2>
      <button id="openBtn" class="px-4 py-2 mt-4 openbtn btn btn-light rounded-pill fw-bold">
        Open Invitation
      </button>
    </div>
  </section>

  <!-- HEAD -->
  <section id="head" class="text-center bg-light fade-section">
    {{-- <div class="fade-content"> --}}
        <div class="head-top fade-content">
            <h2 class="fw-light">Wedding Invitation</h2>
            <h1 class="fw-bold display-3">{{ $couple->groom_name ?? 'Groom' }} & {{ $couple->bride_name ?? 'Bride' }}'s</h1>
            <p class="fw-bold">{{ \Carbon\Carbon::parse($couple->wedding_date)->format('l, d F Y') }}</p>
        </div>
        <div class="head-bottom fade-content">
            <p class="fs-4 ">With the blessing of God, we joyfully invite you to our wedding celebration</p>
        </div>
        <div class="mt-4 countdown simply-countdown-dark fade-content"></div>
    {{-- </div> --}}
  </section>

  <!-- INFO -->
  <section id="info" class="fade-section">
    <div class="container profile-card ">
        <div class="mt-5 row couple fade-content">
           @if($groom)
                <div class="col-lg-6 fade-content" style="margin-top: 12px !important; margin-bottom: 12px !important;">
                    <div class="row">
                        <div class=" col-6 text-end">
                            <h3>{{ $groom->full_name ?? $couple->groom_name ?? 'Groom' }}</h3>
                            <p>{{ $groom->additional_info ? $groom->additional_info : 'Son of Mr. and Mrs.' }}</p>
                            @if($groom->personParent)
                            <p>Son of {{ $groom->personParent->father_name ?? 'Father' }} & {{ $groom->personParent->mother_name ?? 'Mother' }}</p>
                            @endif
                        </div>
                        <div class="col-6">
                            <img src="{{ $groom->image_url ? asset($groom->image_url) : asset('inv/img/gpt2.png') }}"  alt="{{ $groom->full_name ?? $couple->groom_name ?? 'Groom' }}"  class="rounded img-responsive " style="object-position: 70% center; ">
                        </div>
                    </div>
                </div>
            @endif
            @if($bride)
                <div class="col-lg-6 fade-content" style="margin-top: 12px !important; margin-bottom: 12px !important;">
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ $bride->image_url ? url($bride->image_url) : url('inv/img/gpt3.png') }}"  alt="{{ $bride->full_name ?? $couple->bride_name ?? 'Bride' }}" class="rounded img-responsive " style="object-position: 20% center;  ">
                        </div>
                        <div class=" col-6 text-start">
                            <h3>{{ $bride->full_name ?? $couple->bride_name ?? 'Bride' }}</h3>
                        <p>{{ $bride->additional_info ? $bride->additional_info : 'Daughter of Mr. and Mrs.' }}</p>
                        @if($bride->personParent)
                        <p>Daughter of {{ $bride->personParent->father_name ?? 'Father' }} & {{ $bride->personParent->mother_name ?? 'Mother' }}</p>
                        @endif
                        </div>
                    </div>
                </div>
            @endif
            </div>
    </div>
  </section>

  <!-- GALLERY -->
  @if($galleryImages && $galleryImages->count() > 0)
  <section id="gallery" class=" fade-section">
    <div class="mb-5 text-center fade-content">
      <h2 class="fw-bold">Captured Intimacy</h2>
      <p class="text-muted">Setiap bingkai menyimpan kisah penuh kehangatan dan kedekatan</p>
    </div>
    <div class="row fade-content">
      @foreach($galleryImages as $image)
        <a href="{{ url($image->image_url) }}" data-toggle="lightbox" data-gallery="example-gallery" data-size="lg"  class="col-sm-4 gallery-item">
            <img src="{{ url($image->image_url) }}" class="img-fluid" style="border-radius:15px">
            @if($image->description)
            <div class="overlay">
              <p>{{ $image->description }}</p>
            </div>
            @endif
        </a>
      @endforeach
    </div>
  </section>
  @endif
  
  <!-- LOCATION -->
  @if($location)
  <section id="location" class="fade-section">
    <div class="container text-center fade-content">
      <div class="container profile-card ">
        <h2>Wedding Celebration</h2>
        <div class="mt-5 row couple fade-content">
                <div class="col-lg-6 fade-content" style="margin-top: 12px !important; margin-bottom: 12px !important;">
                  <h3>{{ \Carbon\Carbon::parse($weddingEvent->event_date)->format('l, d F Y') }}</h3>
                  <p>{{ $weddingEvent->event_time }} - End</p>
                  <h3>{{ $location->venue_name }}</h3>
                  <h3>{{ $location->address }}</h3>
                </div>
                <div class="col-lg-6 fade-content" style="margin-top: 12px !important; margin-bottom: 12px !important;">
                  @if($location->map_embed_url)
                  {!! $location->map_embed_url !!}
                  @else
                  <p>Location details will be updated soon</p>
                  @endif
                </div>
            </div>
      </div>
    </div>
  </section>
  @endif

  <!-- Reservation -->
  <section id="reservation" class="fade-section">
    <div class="fade-content">
      <h2 class="mb-4">Your Invitation</h2>
    </div>
    <div class="invitation-card">
    <!-- Bagian kiri: Barcode -->
      <div class="card-left">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ route('invitation.show', ['id' => $invitation->id]) }}" 
            alt="Reservation Barcode" />
        <p class="code">Kode: {{ $invitation->invitation_code }}</p>
      </div>

    <!-- Bagian kanan: Informasi Undangan -->
      <div class="card-right">
        <h2 class="invite-header">Undangan Spesial</h2>
        <h2 class="invite-detail"><strong>Kepada</strong><br> {{ $guestName }}</h2>
        <h2 class="invite-header">Wedding Matrimony</h2>
        <p class="invite-detail"><i class="bi bi-calendar-check fs-4"></i> {{ \Carbon\Carbon::parse($weddingEvent->event_date)->format('l, d F Y') }}</p>
        <p class="invite-detail"><i class="bi bi-clock fs-4"></i> {{ $weddingEvent->event_time }} WIB</p>
        <p class="invite-detail"><i class="bi bi-geo-alt fs-4"></i> {{ $location->venue_name ?? 'Venue' }}, {{ $location->address ?? 'Address' }}</p>
      </div>
    </div>
  </section>

  <!-- Story -->
  @if($timelineEvents && $timelineEvents->count() > 0)
  <section id="story" class="py-5 story">
    <div class="container">
      <h2 class="mb-5 text-center" style="color:#e83e8c;">Our Journey</h2>
    </div>
    <div class="container profile-card">
      @foreach($timelineEvents as $index => $event)
      @if($index % 2 == 0)
        <ul class="timeline">
          <li>
            <div class="timeline-image" style="background-image: url('{{ $event->image_url ? asset($event->image_url) : asset('inv/img/gpt2.png') }}') ;"></div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <span class="date">{{ \Carbon\Carbon::parse($event->event_date)->format('F Y') }}</span>
              </div>
              <div class="timeline-body">
                {{-- <h4>{{ $event->title }}</h4> --}}
                <p>{{ $event->description }}</p>
              </div>
          </li>
        </ul>
      @else
        <ul class="timeline">
          <li class="timeline-inverted">
              <div class="timeline-image" style="background-image: url('{{ $event->image_url ? asset($event->image_url) : asset('inv/img/gpt2.png') }}');"></div>
              <div class="timeline-panel">
                  <div class="timeline-heading">
                    <span>{{ \Carbon\Carbon::parse($event->event_date)->format('F Y') }}</span>
                  </div>
                  <div class="timeline-body">
                    {{-- <h4>{{ $event->title }}</h4> --}}
                    <p>{{ $event->description }}</p>
                  </div>
              </div>
          </li>
        </ul>
        @endif
        @endforeach
    </div>
  </section>
  @endif

  <!-- Gift -->
  <section id="gift" class="fade-section">
    <div class="container">
      <h2 class="mb-4 text-center" style="color:#e83e8c;">Wedding Gift</h2>
      <p class="mb-5 text-center">Doa restu Anda sudah merupakan hadiah terbaik bagi kami. Namun jika ingin memberikan tanda kasih, dapat melalui rekening berikut:</p>

      <!-- Card Gift -->
      <!-- Card Informasi -->
      @if($gifts && $gifts->count() > 0)
      <div class="mb-5 text-center border-0 shadow-lg card" style="border-radius:20px;">
        <div class="card-body">
          @foreach($gifts as $gift)
          @if($gift->is_active)
          <h5 class="mb-3 fw-bold">Transfer Hadiah</h5>
          <p><strong>BCA</strong><br>123-456-789<br>a.n. Nama Mempelai</p>
          <button class="btn btn-outline-pink copy-btn" data-account="123456789">
            Salin Nomor Rekening
          </button>
           @else
           <h5 class="mb-3 fw-bold">Tanpa Mengurangi Rasa Hormat</h5>
          <p class="mb-0" style="font-size:1.1rem; line-height:1.7;">
            Kami dengan tulus memohon agar tidak memberikan sumbangan dalam bentuk apapun.  
            Kehadiran Anda dalam hari bahagia kami sudah lebih dari cukup,  
            dan kami ingin berbagi kebahagiaan bersama orang-orang yang kami cintai. 💕
          </p>
          @endif
          @endforeach
        </div>
      </div>
    @else
      <div class="mb-5 text-center border-0 shadow-lg card" style="border-radius:20px;">
        <div class="p-4 card-body">
          <h5 class="mb-3 fw-bold">Tanpa Mengurangi Rasa Hormat</h5>
          <p class="mb-0" style="font-size:1.1rem; line-height:1.7;">
            Kami dengan tulus memohon agar tidak memberikan sumbangan dalam bentuk apapun.  
            Kehadiran Anda dalam hari bahagia kami sudah lebih dari cukup,  
            dan kami hanya ingin berbagi kebahagiaan bersama orang-orang yang kami cintai. 💕
          </p>
        </div>
      </div>
    @endif

      <!-- Card Form -->
      <div class="mb-4 border-0 shadow card" style="border-radius:20px;">
        <div class="card-body">
          <h5 class="mb-3 text-center fw-bold">Kirim Pesan & Doa</h5>
          <form id="giftForm">
            <div class="mb-3">
              <input type="text" class="form-control" name="nama" placeholder="Nama Anda" required>
            </div>
            <div class="mb-3">
              <textarea class="form-control" name="pesan" rows="3" placeholder="Tulis pesan & doa..." required></textarea>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-pink">Kirim</button>
            </div>
          </form>
        </div>
      </div>

      <!-- List Pesan -->
      <div class="mt-4 messages">
        <h5 class="mb-4 text-center">Pesan & Doa</h5>
        <div id="" class="gap-3 messageList d-flex flex-column">
          <!-- Contoh Pesan -->
          <div class="p-3 border-0 shadow-sm card">
            <strong>Andi:</strong>
            <p class="mb-0">Selamat menempuh hidup baru, semoga bahagia selalu!</p>
          </div>
          <div class="p-3 border-0 shadow-sm card">
            <strong>Bella:</strong>
            <p class="mb-0">Doa terbaik untuk kalian berdua 💕</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="p-3 text-center text-white bg-dark">
    <p class="mb-0">© 2025 Agus & Joy Wedding Invitation | Powered by Digital Invitation</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>//cover open
    const cover = document.getElementById('cover');
    const openBtn = document.getElementById('openBtn');

    openBtn.addEventListener('click', () => {
      cover.classList.add('hidden');
      document.body.style.overflow = 'auto'; // unlock scroll

      // Trigger fade-in pertama untuk head setelah cover hilang
      setTimeout(() => {
        document.querySelectorAll('#head .fade-content').forEach(el => {
          el.classList.add('visible');
        });
      }, 600);
    });

    // Observer untuk semua section setelah head
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.querySelectorAll('.fade-content').forEach(el => {
            el.classList.add('visible');
          });
        }
      });
    }, { threshold: 0.2 });

    // observe semua section (kecuali cover)
    document.querySelectorAll('.fade-section').forEach(section => {
      if (section.id !== 'head') observer.observe(section);
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.5/dist/index.bundle.min.js"></script>
  <script src="{{url('simplycountdown/dist/simplyCountdown.umd.js')}}"></script>
  <script>//countdown
        simplyCountdown(".countdown", {
            year: 2025,
            month: 12,
            day: 25,
            hours: 9,
            words: {
                days: {
                    lambda: (root, count) => (count === 1 ? "Hari" : "Hari"),
                    root: "Hari",
                },
                hours: {
                    lambda: (root, count) => (count === 1 ? "Jam" : "Jam"),
                    root: "Jam",
                },
                minutes: {
                    lambda: (root, count) => (count === 1 ? "Menit" : "Menit"),
                    root: "Menit",
                },
                seconds: {
                    lambda: (root, count) => (count === 1 ? "Detik" : "Detik"),
                    root: "Detik",
                },
            },
        });
  </script>
  <script>// Copy rekening
    document.querySelectorAll(".copy-btn").forEach(btn => {
        btn.addEventListener("click", function () {
          navigator.clipboard.writeText(this.dataset.account);
          this.innerText = "Disalin!";
          setTimeout(() => this.innerText = "Salin Nomor Rekening", 2000);
        });
      });

      // Simulasi simpan pesan (local, tanpa backend)
      const form = document.getElementById("giftForm");
      const messageList = document.getElementById("messageList");

      form.addEventListener("submit", function(e){
        e.preventDefault();
        const nama = this.nama.value.trim();
        const pesan = this.pesan.value.trim();
        if(nama && pesan){
          const card = document.createElement("div");
          card.className = "card border-0 shadow-sm p-3 fade-in";
          card.innerHTML = `<strong>${nama}:</strong><p class="mb-0">${pesan}</p>`;
          messageList.prepend(card); // tambahkan di atas
          this.reset();
        }
      });
    </script>
</body>

</html>
