@extends ('layout.app')

@section ('content')
  <div class="max-w-7xl mx-auto px-2 sm:px-6">
    <section
      id="hero"
      class="flex flex-col items-center text-center justify-center bg-[#f4fff4] bg-[linear-gradient(180deg,#DBFFDB_0%,#F4FFF4_100%)] rounded-2xl border border-green-500 p-6 pt-14 sm:p-12 sm:pt-16 min-h-[45vh] max-sm:max-h-[760px] lg:min-h-[50vh] mt-6 sm:mt-12 relative"
    >
      <span
        class="absolute inline-block top-0 left-1/2 -translate-x-1/2 bg-green-500 rounded-b-2xl py-2 px-4 sm:py-4 sm:px-8 text-xs sm:text-base md:text-2xl font-josefin-sans font-semibold text-white border-r border-b border-l border-green-500 shadow-lg shadow-green-500/50/50 uppercase w-[80%] sm:w-auto text-center sm:text-nowrap"
      >
        Rumah Tahfidz Al-Qur'an Ar-Rasyid Sawah Lunto
      </span>
      <h1
        class="font-josefin-sans font-semibold text-2xl sm:text-4xl md:text-5xl leading-tight sm:leading-16 md:leading-20 max-w-full sm:max-w-9/12 mx-auto"
      >
        Patungan Kebaikan, Tumbuh Bersama Cetak Generasi Qur'ani
      </h1>
      <p class="text-base sm:text-xl mt-3 sm:mt-4">Rumah Tahfidz Al-Qur'an Ar-Rasyid Sawah Lunto hadir sebagai wadah pencetak hafidz yang amanah. Salurkan donasi Anda dan pantau penyaluran dana secara terbuka, jujur, serta real-time kapan saja.</p>
      <a
        href="#donate"
        class="mt-6 sm:mt-12 px-5 py-2 sm:px-6 sm:py-3 bg-green-500 text-white text-base sm:text-xl font-semibold rounded-full hover:bg-green-600 hover:outline-2 hover:outline-emerald-400 transition ease-in duration-200"
        >Donasi Sekarang</a
      >
    </section>

    <section class="mt-8 sm:mt-20" id="about-us">
      <h2
        class="uppercase text-xl sm:text-2xl font-semibold text-center mb-6 font-josefin-sans"
      >
        Tentang Kami
      </h2>

      <div class="text-center mb-8 sm:mb-10">
        <h3
          class="font-josefin-sans font-semibold text-2xl sm:text-4xl md:text-5xl mb-3 sm:mb-4"
        >
          Lembaga Tahfidz Amanah<br />untuk Generasi Qur'ani
        </h3>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-7 sm:leading-8">RTQ Ar-Rasyid hadir membuka jalan hafalan Al-Qur'an yang gratis, terbuka, dan berdampak nyata bagi anak-anak dhuafa di Sawah Lunto.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10 sm:mb-14">
        @foreach (['about-us-2', 'about-us-3', 'about-us-4'] as $img)
          <div class="overflow-hidden rounded-2xl">
            <img
              src="{{ asset('images/about-us/' . $img . '.jpeg') }}"
              alt="{{ $img }}"
              class="w-full h-56 sm:h-64 object-cover transition-transform duration-300 hover:scale-110 shadow-lg shadow-green-500/50"
            />
          </div>
        @endforeach
      </div>

      <section
        class="flex flex-col lg:flex-row sm:items-center justify-between mb-10 sm:mb-14 gap-6 sm:gap-8"
      >
        <img
          class="rounded-xl w-full lg:max-w-5/12 h-56 lg:h-auto object-cover shadow-lg shadow-green-500/50"
          src="{{ asset('images/about-us/about-us-4.jpeg') }}"
          alt="Tentang Kami"
        />
        <div class="space-y-3 sm:space-y-4 lg:max-w-6/12">
          <h2
            class="text-2xl sm:text-3xl md:text-4xl font-semibold leading-tight sm:leading-12 md:leading-14"
          >
            Menjaga Kalam-Mu, Mencetak Generasi Qur'ani di Pelosok Negeri
          </h2>
          <p class="leading-7 sm:leading-8 text-sm sm:text-base">Rumah Tahfidz Al-Qur'an (RTQ) Ar-Rasyid adalah lembaga pendidikan non-profit di Sawah Lunto, Sumatera Barat, yang mendedikasikan diri untuk mencetak generasi penjaga Al-Qur'an secara gratis bagi anak-anak dan santri dhuafa. Kami memadukan metode hafalan yang kokoh dengan penanaman akhlak mulia sejak dini.</p>
          <p class="leading-7 sm:leading-8 text-sm sm:text-base">Sebagai wujud tanggung jawab mutlak kepada umat, kami mengutamakan transparansi dan akuntabilitas. Melalui platform ini, setiap rupiah donasi yang Anda titipkan akan tercatat secara real-time dan dilaporkan penyalurannya secara terbuka. Bersama RTQ Ar-Rasyid, mari alirkan kebaikan yang bersih, amanah, dan berdampak nyata bagi masa depan santri.</p>
        </div>
      </section>

      <div
        class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-12 sm:mb-16"
      >
        <div
          class="flex flex-col items-center text-center bg-green-50 border border-green-200 rounded-2xl py-8 sm:py-10 px-6"
        >
          <span
            class="font-josefin-sans font-bold text-4xl sm:text-5xl text-green-600 mb-2"
            >5</span
          >
          <span class="text-base sm:text-lg font-semibold text-gray-700"
            >Tahun Beroperasi</span
          >
          <p class="text-xs sm:text-sm text-gray-500 mt-2">Melayani sejak 2020 dengan dedikasi penuh</p>
        </div>
        <div
          class="flex flex-col items-center text-center bg-green-50 border border-green-200 rounded-2xl py-8 sm:py-10 px-6"
        >
          <span
            class="font-josefin-sans font-bold text-4xl sm:text-5xl text-green-600 mb-2"
            >100+</span
          >
          <span class="text-base sm:text-lg font-semibold text-gray-700"
            >Santri Aktif</span
          >
          <p class="text-xs sm:text-sm text-gray-500 mt-2">Santri dhuafa yang dibina tanpa biaya</p>
        </div>
        <div
          class="flex flex-col items-center text-center bg-green-50 border border-green-200 rounded-2xl py-8 sm:py-10 px-6"
        >
          <span
            class="font-josefin-sans font-bold text-4xl sm:text-5xl text-green-600 mb-2"
            >3</span
          >
          <span class="text-base sm:text-lg font-semibold text-gray-700"
            >Jenis Kelas</span
          >
          <p class="text-xs sm:text-sm text-gray-500 mt-2">Tahfidz, Tartil, dan Tilawah Al-Qur'an</p>
        </div>
      </div>
    </section>

    <section class="mt-8 sm:mt-20 mb-16" id="activities">
      <h2
        class="uppercase text-xl sm:text-2xl font-semibold text-center mb-6 sm:mb-10 font-josefin-sans"
      >
        Laporan Kegiatan
      </h2>

      <div class="flex flex-col gap-4 sm:gap-6">
        @forelse ($activities as $activity)
          <div
            class="flex flex-col sm:flex-row border border-gray-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-green-400 hover:shadow-lg hover:shadow-green-100 cursor-pointer activity-card"
            data-name="{{ $activity->name }}"
            data-date="{{ $activity->activity_date->translatedFormat('d F Y') }}"
            data-description="{{ $activity->description }}"
            data-image="{{ $activity->proof_of_activity ? asset('storage/' . $activity->proof_of_activity) : '' }}"
          >
            @if ($activity->proof_of_activity)
              <img
                src="{{ asset('storage/' . $activity->proof_of_activity) }}"
                alt="{{ $activity->name }}"
                class="w-full h-48 sm:w-2/5 sm:h-auto object-cover shadow-lg shadow-green-500/50"
              />
            @else
              <div class="w-full h-48 sm:w-2/5 sm:h-auto bg-green-50 flex items-center justify-center">
                <span class="text-green-300 font-semibold text-base sm:text-lg tracking-widest uppercase">RTQ Ar-Rasyid</span>
              </div>
            @endif
            <div class="w-full sm:w-3/5 p-5 sm:p-8 flex flex-col justify-center">
              <span class="text-xs text-gray-400 mb-1">{{ $activity->activity_date->translatedFormat('d F Y') }}</span>
              <h3 class="font-josefin-sans font-semibold text-xl sm:text-2xl mb-2 sm:mb-3">
                {{ $activity->name }}
              </h3>
              <p class="text-sm sm:text-base text-gray-600 leading-6 sm:leading-7">{{ $activity->description }}</p>
              <span class="mt-4 text-sm font-semibold text-green-600 flex items-center gap-1">
                Lihat Detail
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </span>
            </div>
          </div>
        @empty
          <div class="text-center text-gray-400 py-12">Belum ada kegiatan.</div>
        @endforelse
      </div>
    </section>

    {{-- Activity Detail Modal --}}
    <div id="activity-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
      <div id="modal-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
      <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto z-10">
        <button id="modal-close" class="absolute top-4 right-4 z-10 bg-white rounded-full p-1.5 shadow hover:bg-gray-100 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
        <div id="modal-image-wrap" class="w-full">
          <img id="modal-image" src="" alt="" class="w-full h-56 sm:h-72 object-cover rounded-t-2xl" />
        </div>
        <div id="modal-placeholder" class="w-full h-40 bg-green-50 rounded-t-2xl hidden items-center justify-center">
          <span class="text-green-300 font-semibold text-lg tracking-widest uppercase">RTQ Ar-Rasyid</span>
        </div>
        <div class="p-6 sm:p-8">
          <span id="modal-date" class="text-xs text-gray-400 block mb-2"></span>
          <h2 id="modal-name" class="font-josefin-sans font-bold text-2xl sm:text-3xl text-gray-800 mb-4"></h2>
          <p id="modal-description" class="text-sm sm:text-base text-gray-600 leading-7"></p>
        </div>
      </div>
    </div>

    <script>
      const modal = document.getElementById('activity-modal');
      const modalClose = document.getElementById('modal-close');
      const modalBackdrop = document.getElementById('modal-backdrop');

      function openModal(data) {
        document.getElementById('modal-name').textContent = data.name;
        document.getElementById('modal-date').textContent = data.date;
        document.getElementById('modal-description').textContent = data.description;

        const imgEl = document.getElementById('modal-image');
        const imgWrap = document.getElementById('modal-image-wrap');
        const placeholder = document.getElementById('modal-placeholder');

        if (data.image) {
          imgEl.src = data.image;
          imgEl.alt = data.name;
          imgWrap.classList.remove('hidden');
          placeholder.classList.add('hidden');
          placeholder.classList.remove('flex');
        } else {
          imgWrap.classList.add('hidden');
          placeholder.classList.remove('hidden');
          placeholder.classList.add('flex');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
      }

      function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
      }

      document.querySelectorAll('.activity-card').forEach(card => {
        card.addEventListener('click', () => openModal({
          name: card.dataset.name,
          date: card.dataset.date,
          description: card.dataset.description,
          image: card.dataset.image,
        }));
      });

      modalClose.addEventListener('click', closeModal);
      modalBackdrop.addEventListener('click', closeModal);
      document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
    </script>
  </div>
  <section
    id="donate"
    class="-mx-6 lg:-mx-16 bg-[linear-gradient(135deg,#22c55e_0%,#14532d_100%)] py-14 sm:py-20"
  >
    <div class="max-w-7xl mx-auto px-8">
      <div class="flex flex-col sm:flex-row items-center gap-8 sm:gap-12">
        <img
          src="{{ asset('images/about-us/about-us-2.jpeg') }}"
          alt="Donasi RTQ Ar-Rasyid"
          class="w-full h-56 sm:w-6/12 sm:h-80 md:sm:h-96 object-cover rounded-2xl shadow-lg shadow-green-500/50"
        />
        <div class="w-full sm:w-6/12 text-white">
          <span
            class="uppercase text-xs sm:text-sm font-semibold tracking-widest text-green-300 mb-3 block"
            >Donasi</span
          >
          <h2
            class="font-josefin-sans font-bold text-2xl sm:text-3xl md:text-4xl mb-4 leading-tight"
          >
            Wujudkan Kebaikan, Jadilah Bagian dari Perubahan
          </h2>
          <p class="text-sm sm:text-base leading-7 text-green-100 mb-8">Setiap rupiah yang Anda donasikan langsung berdampak bagi masa depan santri dhuafa di RTQ Ar-Rasyid. Donasi Anda membiayai kebutuhan pendidikan, operasional pesantren, dan kehidupan sehari-hari para penghafal Al-Qur'an. Bersama, kita wujudkan generasi Qur'ani yang kuat, berakhlak, dan berdaya.</p>
          <div class="flex flex-col lg:flex-row gap-4">
            <a
              href="https://api.whatsapp.com/send?phone=6282170078083&text=Assalamu'alaikum%20Warohmatullohi%20Wabarokatuh%0A%0ASaya%20Mau%20Donasi%20dengan%20data%0A%0ANama%3A%20%0ANominal%3A%0APesan%3A%20%0A%0A"
              class="inline-block px-6 py-3 bg-green-600 text-gray-50 font-bold rounded-full hover:bg-green-600/90 hover:shadow-lg transition-all duration-200 text-base text-center sm:text-lg"
              target="_blank" rel="noopener noreferrer"
              >
              Donasi Via WA
            </a>
            <button
              id="btn-donate"
              type="button"
              class="inline-block px-6 py-3 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 hover:shadow-lg transition-all duration-200 text-base text-center sm:text-lg cursor-pointer"
            >
              Donasi Langsung
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Donation Modal --}}
  <div id="donation-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div id="donation-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto z-10">
      <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <h2 class="font-josefin-sans font-bold text-xl text-gray-800">Donasi Langsung</h2>
        <button id="donation-close" class="p-1.5 rounded-full hover:bg-gray-100 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <form id="donation-form" class="p-6 space-y-4" novalidate>
        @csrf

        <div id="donation-error" class="hidden bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3"></div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
          <input type="text" id="name-input" name="name" maxlength="255" placeholder="Masukkan nama Anda"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition text-sm" />
          <p id="name-error" class="hidden text-xs text-red-500 mt-1"></p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp <span class="text-red-500">*</span></label>
          <input type="tel" id="phone-input" name="phone" placeholder="08xxxxxxxxxx"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition text-sm" />
          <p id="phone-error" class="hidden text-xs text-red-500 mt-1"></p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
          <input type="email" id="email-input" name="email" placeholder="email@contoh.com"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition text-sm" />
          <p id="email-error" class="hidden text-xs text-red-500 mt-1"></p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Donasi <span class="text-red-500">*</span></label>
          <div class="grid grid-cols-3 gap-2 mb-2">
            @foreach ([50000, 100000, 200000, 300000, 500000, 1000000] as $nominal)
              <button type="button" data-amount="{{ $nominal }}"
                class="amount-preset px-3 py-2 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:border-green-400 hover:text-green-700 hover:bg-green-50 transition">
                Rp {{ number_format($nominal, 0, ',', '.') }}
              </button>
            @endforeach
          </div>
          <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-500">Rp</span>
            <input type="number" name="amount" id="amount-input" min="10000" required placeholder="Atau masukkan nominal lain"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition text-sm" />
          </div>
        </div>

        <div>
          <div class="flex justify-between items-center mb-1">
            <label class="block text-sm font-medium text-gray-700">Pesan / Doa (opsional)</label>
            <span id="notes-counter" class="text-xs text-gray-400">0 / 200</span>
          </div>
          <textarea id="notes-input" name="notes" rows="2" maxlength="200" placeholder="Tulis pesan atau doa untuk santri..."
            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition text-sm resize-none"></textarea>
          <p id="notes-error" class="hidden text-xs text-red-500 mt-1">Pesan maksimal 200 karakter.</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran <span class="text-red-500">*</span></label>

          <p class="text-xs text-gray-400 mb-1.5">Virtual Account</p>
          <div class="grid grid-cols-3 gap-2 mb-3">
            @foreach ([
              'BC' => 'BCA VA',
              'M2' => 'Mandiri VA',
              'BT' => 'Permata VA',
              'I1' => 'BNI VA',
              'BV' => 'BSI VA',
              'M1' => 'Maybank VA',
            ] as $code => $label)
              <button type="button" data-method="{{ $code }}"
                class="payment-method-btn px-2 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-600 hover:border-green-400 hover:text-green-700 hover:bg-green-50 transition text-center">
                {{ $label }}
              </button>
            @endforeach
          </div>

          <p class="text-xs text-gray-400 mb-1.5">E-Wallet</p>
          <div class="grid grid-cols-4 gap-2 mb-3">
            @foreach ([
              'OV' => 'OVO',
              'DA' => 'DANA',
              'SL' => 'ShopeePay',
              'LT' => 'LinkAja',
            ] as $code => $label)
              <button type="button" data-method="{{ $code }}"
                class="payment-method-btn px-2 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-600 hover:border-green-400 hover:text-green-700 hover:bg-green-50 transition text-center">
                {{ $label }}
              </button>
            @endforeach
          </div>

          <p class="text-xs text-gray-400 mb-1.5">Lainnya</p>
          <div class="grid grid-cols-3 gap-2">
            @foreach ([
              'OL' => 'QRIS',
              'VC' => 'Kartu Kredit',
              'A1' => 'Alfamart',
            ] as $code => $label)
              <button type="button" data-method="{{ $code }}"
                class="payment-method-btn px-2 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-600 hover:border-green-400 hover:text-green-700 hover:bg-green-50 transition text-center">
                {{ $label }}
              </button>
            @endforeach
          </div>

          <input type="hidden" name="payment_method" id="payment-method-input" value="" />
          <p id="payment-method-error" class="hidden text-xs text-red-500 mt-1">Pilih metode pembayaran.</p>
        </div>

        <button type="submit" id="donation-submit"
          class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition duration-200 text-sm flex items-center justify-center gap-2">
          <span id="submit-text">Lanjutkan ke Pembayaran</span>
          <svg id="submit-spinner" class="hidden h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
          </svg>
        </button>
      </form>
    </div>
  </div>

  <script>
    // Donation modal
    const donationModal    = document.getElementById('donation-modal');
    const donationClose    = document.getElementById('donation-close');
    const donationBackdrop = document.getElementById('donation-backdrop');
    const donationForm     = document.getElementById('donation-form');
    const donationError    = document.getElementById('donation-error');
    const amountInput      = document.getElementById('amount-input');

    document.getElementById('btn-donate').addEventListener('click', () => {
      donationModal.classList.remove('hidden');
      donationModal.classList.add('flex');
      document.body.style.overflow = 'hidden';
    });

    function closeDonationModal() {
      donationModal.classList.add('hidden');
      donationModal.classList.remove('flex');
      document.body.style.overflow = '';
    }

    donationClose.addEventListener('click', closeDonationModal);
    donationBackdrop.addEventListener('click', closeDonationModal);

    // Preset amount buttons
    document.querySelectorAll('.amount-preset').forEach(btn => {
      btn.addEventListener('click', () => {
        amountInput.value = btn.dataset.amount;
        document.querySelectorAll('.amount-preset').forEach(b => b.classList.remove('border-green-500', 'text-green-700', 'bg-green-50'));
        btn.classList.add('border-green-500', 'text-green-700', 'bg-green-50');
      });
    });

    // Payment method buttons
    const paymentMethodInput = document.getElementById('payment-method-input');
    const paymentMethodError = document.getElementById('payment-method-error');

    document.querySelectorAll('.payment-method-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.payment-method-btn').forEach(b => b.classList.remove('border-green-500', 'text-green-700', 'bg-green-50'));
        btn.classList.add('border-green-500', 'text-green-700', 'bg-green-50');
        paymentMethodInput.value = btn.dataset.method;
        paymentMethodError.classList.add('hidden');
      });
    });

    // Field validation helpers
    const nameInput  = document.getElementById('name-input');
    const nameError  = document.getElementById('name-error');
    const phoneInput = document.getElementById('phone-input');
    const phoneError = document.getElementById('phone-error');
    const emailInput = document.getElementById('email-input');
    const emailError = document.getElementById('email-error');
    const notesInput   = document.getElementById('notes-input');
    const notesCounter = document.getElementById('notes-counter');
    const notesError   = document.getElementById('notes-error');

    const phoneRegex = /^(\+62|62|0)8[1-9][0-9]{7,10}$/;
    const emailRegex = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;

    function setFieldError(input, errorEl, msg) {
      errorEl.textContent = msg;
      errorEl.classList.toggle('hidden', !msg);
      input.classList.toggle('border-red-400', !!msg);
      input.classList.toggle('border-gray-300', !msg);
    }

    function validateName() {
      const val = nameInput.value.trim();
      if (!val) { setFieldError(nameInput, nameError, 'Nama lengkap wajib diisi.'); return false; }
      if (val.length < 2) { setFieldError(nameInput, nameError, 'Nama minimal 2 karakter.'); return false; }
      setFieldError(nameInput, nameError, '');
      return true;
    }

    function validatePhone() {
      const val = phoneInput.value.trim().replace(/[\s\-]/g, '');
      if (!val) { setFieldError(phoneInput, phoneError, 'No. WhatsApp wajib diisi.'); return false; }
      if (!phoneRegex.test(val)) { setFieldError(phoneInput, phoneError, 'Format tidak valid. Contoh: 08123456789'); return false; }
      setFieldError(phoneInput, phoneError, '');
      return true;
    }

    function validateEmail() {
      const val = emailInput.value.trim();
      if (!val) { setFieldError(emailInput, emailError, 'Email wajib diisi.'); return false; }
      if (!emailRegex.test(val)) { setFieldError(emailInput, emailError, 'Format email tidak valid.'); return false; }
      setFieldError(emailInput, emailError, '');
      return true;
    }

    nameInput.addEventListener('input', validateName);
    nameInput.addEventListener('blur', validateName);
    phoneInput.addEventListener('input', validatePhone);
    phoneInput.addEventListener('blur', validatePhone);
    emailInput.addEventListener('input', validateEmail);
    emailInput.addEventListener('blur', validateEmail);

    // Notes character counter
    notesInput.addEventListener('input', () => {
      const len = notesInput.value.length;
      notesCounter.textContent = `${len} / 200`;
      notesCounter.classList.toggle('text-red-500', len >= 180);
      notesCounter.classList.toggle('text-gray-400', len < 180);
      notesError.classList.toggle('hidden', len <= 200);
    });

    // Form submit
    donationForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      donationError.classList.add('hidden');

      const nameOk   = validateName();
      const phoneOk  = validatePhone();
      const emailOk  = validateEmail();
      const amountVal = amountInput.value;

      if (!nameOk || !phoneOk || !emailOk) return;

      if (!amountVal || Number(amountVal) < 10000) {
        donationError.textContent = 'Jumlah donasi minimal Rp 10.000.';
        donationError.classList.remove('hidden');
        return;
      }

      if (! paymentMethodInput.value) {
        paymentMethodError.classList.remove('hidden');
        return;
      }

      const submitBtn  = document.getElementById('donation-submit');
      const submitText = document.getElementById('submit-text');
      const spinner    = document.getElementById('submit-spinner');

      submitBtn.disabled = true;
      submitText.textContent = 'Memproses...';
      spinner.classList.remove('hidden');

      const formData = new FormData(donationForm);

      try {
        const res = await fetch('{{ route('donate') }}', {
          method: 'POST',
          headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': formData.get('_token') },
          body: formData,
        });

        const data = await res.json();

        if (!res.ok) {
          // Laravel validation errors (422) return { errors: { field: ['msg'] } }
          if (data.errors) {
            const messages = Object.values(data.errors).flat();
            donationError.textContent = messages.join(' ');
          } else {
            donationError.textContent = data.message ?? 'Terjadi kesalahan. Silakan coba lagi.';
          }
          donationError.classList.remove('hidden');
          console.error('Donation error:', data);
          return;
        }

        if (data.payment_url) {
          const loadingUrl = `{{ route('donation.loading') }}?redirect=` + encodeURIComponent(data.payment_url);
          window.location.href = loadingUrl;
        } else {
          donationError.textContent = 'Tidak ada URL pembayaran. Hubungi admin.';
          donationError.classList.remove('hidden');
        }
      } catch {
        donationError.textContent = 'Koneksi gagal. Periksa internet Anda.';
        donationError.classList.remove('hidden');
      } finally {
        submitBtn.disabled = false;
        submitText.textContent = 'Lanjutkan ke Pembayaran';
        spinner.classList.add('hidden');
      }
    });
  </script>
@endsection
