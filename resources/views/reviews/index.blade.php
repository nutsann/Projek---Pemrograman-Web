@extends('layouts.app')

@section('title', 'Ulasan Produk - ' . $product->name)

@section('styles')
<style>
  .review-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 70px; }

  /* BREADCRUMB */
  .breadcrumb-wrap {
    padding: 30px 0 15px;
  }
  .breadcrumb-custom {
    font-size: 0.9rem;
    color: #666;
  }
  .breadcrumb-custom a { color: #105746; text-decoration: none; font-weight: 500; }
  .breadcrumb-custom a:hover { text-decoration: underline; }

  /* HEADER */
  .review-header {
    margin-bottom: 28px;
  }
  .review-header h1 {
    font-size: 2.6rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 8px;
    font-family: serif, 'Times New Roman', Times;
  }
  .review-header p {
    font-size: 1.05rem;
    color: #555;
    margin: 0;
  }

  /* MAIN WHITE CARD CONTAINER */
  .review-main-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.04);
  }

  /* RATING SUMMARY ROW */
  .rating-summary-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap;
    padding-bottom: 30px;
  }
  .rating-score-box {
    text-align: center;
    min-width: 180px;
  }
  .big-score {
    font-size: 4.8rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1;
    margin-bottom: 10px;
  }
  .big-stars {
    color: #FFB81C;
    font-size: 1.4rem;
    margin-bottom: 12px;
    display: flex;
    justify-content: center;
    gap: 4px;
  }
  .review-total-text {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a1a1a;
  }

  /* DISTRIBUTION BARS */
  .distribution-box {
    flex: 1;
    min-width: 260px;
    max-width: 480px;
  }
  .dist-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
  }
  .dist-num {
    display: flex;
    align-items: center;
    gap: 4px;
    width: 38px;
  }
  .dist-num i {
    color: #FFB81C;
    font-size: 0.95rem;
  }
  .dist-bar-track {
    flex: 1;
    height: 12px;
    background: #e9ecef;
    border-radius: 999px;
    overflow: hidden;
  }
  .dist-bar-fill {
    height: 100%;
    background: #FFB81C;
    border-radius: 999px;
  }
  .dist-percent {
    width: 48px;
    text-align: right;
    font-size: 1rem;
    color: #333;
  }

  /* WRITE REVIEW BUTTON */
  .action-btn-row {
    padding-bottom: 30px;
    margin-bottom: 10px;
  }
  .btn-tulis-ulasan {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 12px 28px;
    font-size: 1.05rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    display: inline-block;
    text-decoration: none;
  }
  .btn-tulis-ulasan:hover {
    background: #0d4538;
    color: #ffffff;
  }

  /* REVIEW LIST */
  .review-list-item {
    display: flex;
    gap: 20px;
    padding: 24px 0;
    border-top: 1px solid #f0f0f0;
  }
  .reviewer-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    background: #e9ecef;
    flex-shrink: 0;
  }
  .reviewer-content {
    flex: 1;
  }
  .reviewer-top {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 6px;
    flex-wrap: wrap;
    gap: 8px;
  }
  .reviewer-name {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a1a1a;
  }
  .review-date {
    font-size: 0.9rem;
    color: #888;
  }
  .review-stars {
    color: #FFB81C;
    font-size: 1rem;
    margin-bottom: 8px;
    display: flex;
    gap: 2px;
  }
  .review-text {
    font-size: 0.98rem;
    line-height: 1.5;
    color: #333;
    margin: 0;
  }

  /* MODAL / FORM REVIEW ACCORDION */
  .review-form-box {
    background: #faf8f2;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    border: 1px solid #e9e3d0;
  }
  .star-select-wrap {
    display: flex;
    gap: 8px;
    font-size: 1.6rem;
    color: #d5d5d5;
    cursor: pointer;
    margin-bottom: 14px;
  }
  .star-select-wrap .fas.active {
    color: #FFB81C;
  }

  @media (max-width: 767px) {
    .review-main-card { padding: 24px 18px; }
    .rating-summary-row { flex-direction: column; align-items: stretch; gap: 20px; }
    .big-score { font-size: 3.8rem; }
    .distribution-box { max-width: 100%; }
    .review-list-item { gap: 14px; }
    .reviewer-avatar { width: 48px; height: 48px; }
  }
</style>
@endsection

@section('content')
<div class="review-page">

  {{-- BREADCRUMB --}}
  <div class="container breadcrumb-wrap">
    <div class="breadcrumb-custom">
      <a href="{{ route('home') }}">Home</a> &rsaquo;
      <a href="{{ route('marketplace') }}">Marketplace</a> &rsaquo;
      <a href="{{ route('products.detail', $product->slug) }}">{{ $product->name }}</a> &rsaquo;
      <span>Ulasan</span>
    </div>
  </div>

  <div class="container" style="max-width: 960px;">
    {{-- JUDUL HALAMAN --}}
    <div class="review-header">
      <h1>Ulasan Produk</h1>
      <p>Lihat pengalaman pembeli lainnya.</p>
    </div>

    {{-- KARTU PUTIH UTAMA --}}
    <div class="review-main-card">

      @php
        $totalReviews = $product->reviewCount();
        $avgScore = $product->avgRating();

        // Hitung distribusi rating nyata dari database
        $allReviews = $product->reviews;
        $counts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach($allReviews as $r) {
          $rt = (int) $r->rating;
          if(isset($counts[$rt])) $counts[$rt]++;
        }
      @endphp

      {{-- BAGIAN SUMMARY RATING & DISTRIBUSI --}}
      <div class="rating-summary-row">
        {{-- SKOR UTAMA --}}
        <div class="rating-score-box">
          <div class="big-score">{{ number_format($avgScore, 1) }}</div>
          <div class="big-stars">
            @for($i = 1; $i <= 5; $i++)
              @if($i <= round($avgScore))
                <i class="fas fa-star"></i>
              @else
                <i class="far fa-star" style="color:#d5d5d5;"></i>
              @endif
            @endfor
          </div>
          <div class="review-total-text">({{ $totalReviews }} ulasan)</div>
        </div>

        {{-- PROGRESS DISTRIBUSI BINTANG 5 - 1 --}}
        <div class="distribution-box">
          @for($star = 5; $star >= 1; $star--)
            @php
              $c = $counts[$star];
              $pct = $totalReviews > 0 ? round(($c / $totalReviews) * 100) : 0;
            @endphp
            <div class="dist-row">
              <span class="dist-num">{{ $star }} <i class="fas fa-star"></i></span>
              <div class="dist-bar-track">
                <div class="dist-bar-fill" style="width: {{ $pct }}%;"></div>
              </div>
              <span class="dist-percent">{{ $pct }}%</span>
            </div>
          @endfor
        </div>
      </div>

      {{-- TOMBOL & FORM TULIS ULASAN --}}
      <div class="action-btn-row">
        @auth
          @php
            // Cek apakah user pernah membeli produk ini dalam pesanan yang ada
            $userOrder = \App\Models\Order::where('user_id', Auth::id())
              ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
              ->latest()
              ->first();
          @endphp

          <button type="button" class="btn-tulis-ulasan" onclick="toggleReviewForm()">
            Tulis Ulasan
          </button>

          {{-- FORM INPUT ULASAN --}}
          <div id="reviewFormContainer" class="review-form-box mt-3" style="display:none;">
            @if($userOrder)
              <h5 class="fw-bold mb-3 text-dark">Tulis Ulasan Anda</h5>
              <form action="{{ route('reviews.store', $userOrder->id) }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" id="ratingInput" name="rating" value="5">

                <div class="mb-2">
                  <label class="form-label small fw-bold">Pilih Rating Bintang:</label>
                  <div class="star-select-wrap" id="starPicker">
                    <i class="fas fa-star active" data-val="1"></i>
                    <i class="fas fa-star active" data-val="2"></i>
                    <i class="fas fa-star active" data-val="3"></i>
                    <i class="fas fa-star active" data-val="4"></i>
                    <i class="fas fa-star active" data-val="5"></i>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label small fw-bold">Komentar / Pengalaman:</label>
                  <textarea name="comment" class="form-control" rows="3" placeholder="Ceritakan pengalaman Anda terkait kualitas produk..." required></textarea>
                </div>

                <div class="d-flex gap-2">
                  <button type="submit" class="btn-tulis-ulasan" style="padding:8px 20px; font-size:0.95rem;">
                    Kirim Ulasan
                  </button>
                  <button type="button" class="btn btn-outline-secondary" onclick="toggleReviewForm()" style="border-radius:12px;">
                    Batal
                  </button>
                </div>
              </form>
            @else
              <div class="alert alert-warning mb-0 rounded-3">
                <i class="fas fa-info-circle me-1"></i> Anda hanya dapat memberikan ulasan setelah melakukan pembelian produk ini.
              </div>
            @endif
          </div>
        @else
          <a href="{{ route('login') }}" class="btn-tulis-ulasan">
            Tulis Ulasan
          </a>
        @endauth
      </div>

      {{-- DAFTAR ULASAN DARI PEMBELI LAIN --}}
      <div class="reviews-container">
        @forelse($reviews as $rev)
          <div class="review-list-item">
            {{-- AVATAR PEMBELI --}}
            <img
              src="{{ $rev->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($rev->user->name) . '&background=105746&color=fff' }}"
              class="reviewer-avatar"
              alt="{{ $rev->user->name }}"
            >

            {{-- KONTEN ULASAN --}}
            <div class="reviewer-content">
              <div class="reviewer-top">
                <div class="reviewer-name">{{ $rev->user->name }}</div>
                <div class="review-date">
                  {{ $rev->created_at ? $rev->created_at->translatedFormat('d F Y') : '-' }}
                </div>
              </div>

              {{-- BINTANG ULASAN --}}
              <div class="review-stars">
                @for($s = 1; $s <= 5; $s++)
                  @if($s <= $rev->rating)
                    <i class="fas fa-star"></i>
                  @else
                    <i class="far fa-star" style="color:#d5d5d5;"></i>
                  @endif
                @endfor
              </div>

              {{-- TEKS ULASAN --}}
              <p class="review-text">
                {{ $rev->comment ?: 'Pembeli tidak meninggalkan komentar tertulis.' }}
              </p>
            </div>
          </div>
        @empty
          <div class="text-center py-5 text-muted">
            <i class="far fa-comment-dots mb-3" style="font-size:3rem; color:#d5d5d5;"></i>
            <p class="mb-0">Belum ada ulasan untuk produk ini.</p>
          </div>
        @endforelse
      </div>

      {{-- PAGINASI --}}
      <div class="d-flex justify-content-center mt-4">
        {{ $reviews->links() }}
      </div>

    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  function toggleReviewForm() {
    const box = document.getElementById('reviewFormContainer');
    if (box) {
      box.style.display = box.style.display === 'none' ? 'block' : 'none';
    }
  }

  // Interaktivitas Picker Bintang Form Ulasan
  const stars = document.querySelectorAll('#starPicker i');
  const ratingInput = document.getElementById('ratingInput');

  stars.forEach(star => {
    star.addEventListener('click', function() {
      const val = parseInt(this.dataset.val);
      if (ratingInput) ratingInput.value = val;

      stars.forEach(s => {
        if (parseInt(s.dataset.val) <= val) {
          s.classList.add('active');
          s.classList.remove('far');
          s.classList.add('fas');
        } else {
          s.classList.remove('active');
          s.classList.remove('fas');
          s.classList.add('far');
        }
      });
    });
  });
</script>
@endsection
