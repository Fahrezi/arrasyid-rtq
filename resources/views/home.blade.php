@extends ('layout.app')

@section ('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <section
      class="flex flex-col items-center text-center justify-center bg-[#f4fff4] bg-[linear-gradient(180deg,#DBFFDB_0%,#F4FFF4_100%)] rounded-2xl border border-green-500 p-6 pt-14 sm:p-12 sm:pt-16 min-h-[30vh] max-sm:max-h-[760px] lg:min-h-[50vh] mt-6 sm:mt-12 relative"
    >
      <span
        class="absolute inline-block top-0 left-1/2 -translate-x-1/2 bg-green-500 rounded-b-2xl py-2 px-4 sm:py-4 sm:px-8 text-xs sm:text-base md:text-2xl font-josefin-sans font-semibold text-white border-r border-b border-l border-green-500 shadow-lg shadow-green-500/50 uppercase sm:w-auto text-center sm:text-nowrap"
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
              class="w-full h-56 sm:h-64 object-cover transition-transform duration-300 hover:scale-110"
            />
          </div>
        @endforeach
      </div>

      <section
        class="flex flex-col lg:flex-row sm:items-center justify-between mb-10 sm:mb-14 gap-6 sm:gap-8"
      >
        <img
          class="rounded-xl w-full lg:max-w-5/12 h-56 lg:h-auto object-cover"
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
        <div
          class="flex flex-col sm:flex-row border border-gray-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-green-400 hover:shadow-lg hover:shadow-green-100 cursor-pointer"
        >
          <img
            src="{{ asset('images/about-us/about-us-3.jpeg') }}"
            alt="Tahfidz Qur'an"
            class="w-full h-48 sm:w-2/5 sm:h-auto object-cover"
          />
          <div class="w-full sm:w-3/5 p-5 sm:p-8 flex flex-col justify-center">
            <h3
              class="font-josefin-sans font-semibold text-xl sm:text-2xl mb-2 sm:mb-3"
            >
              Tahfidz Qur'an
            </h3>
            <p class="text-sm sm:text-base text-gray-600 leading-6 sm:leading-7">Program hafalan Al-Qur'an intensif yang dirancang untuk anak-anak dan santri dengan metode talaqqi langsung dari ustadz berpengalaman. Setiap santri dibimbing secara personal untuk memperkuat makhraj, tajwid, dan kelancaran hafalan hingga 30 juz.</p>
          </div>
        </div>

        <div
          class="flex flex-col sm:flex-row border border-gray-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-green-400 hover:shadow-lg hover:shadow-green-100 cursor-pointer"
        >
          <img
            src="{{ asset('images/about-us/about-us-4.jpeg') }}"
            alt="Tadabur Alam"
            class="w-full h-48 sm:w-2/5 sm:h-auto object-cover"
          />
          <div class="w-full sm:w-3/5 p-5 sm:p-8 flex flex-col justify-center">
            <h3
              class="font-josefin-sans font-semibold text-xl sm:text-2xl mb-2 sm:mb-3"
            >
              Tadabur Alam
            </h3>
            <p class="text-sm sm:text-base text-gray-600 leading-6 sm:leading-7">Kegiatan tadabur alam mengajak santri mendekatkan diri kepada Allah melalui refleksi dan penghayatan tanda-tanda kebesaran-Nya di alam semesta. Melalui program ini, santri membangun keterhubungan spiritual sekaligus mempererat ukhuwah antar sesama.</p>
          </div>
        </div>

        <div
          class="flex flex-col sm:flex-row border border-gray-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-green-400 hover:shadow-lg hover:shadow-green-100 cursor-pointer"
        >
          <img
            src="{{ asset('images/about-us/about-us-5.jpeg') }}"
            alt="Fiqh Ibadah"
            class="w-full h-48 sm:w-2/5 sm:h-auto object-cover"
          />
          <div class="w-full sm:w-3/5 p-5 sm:p-8 flex flex-col justify-center">
            <h3
              class="font-josefin-sans font-semibold text-xl sm:text-2xl mb-2 sm:mb-3"
            >
              Fiqh Ibadah
            </h3>
            <p class="text-sm sm:text-base text-gray-600 leading-6 sm:leading-7">Pembelajaran fiqh ibadah yang membimbing santri memahami tata cara ibadah sesuai syariat secara mendalam dan benar. Materi mencakup thaharah, shalat, puasa, zakat, dan ibadah harian lainnya agar santri mampu beribadah dengan penuh kesadaran dan keyakinan.</p>
          </div>
        </div>

        <div
          class="flex flex-col sm:flex-row border border-gray-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-green-400 hover:shadow-lg hover:shadow-green-100 cursor-pointer"
        >
          <div
            class="w-full h-40 sm:w-2/5 sm:h-auto bg-gray-100 flex items-center justify-center"
          >
            <span
              class="text-gray-400 font-semibold text-base sm:text-lg tracking-widest uppercase"
              >Coming Soon</span
            >
          </div>
          <div class="w-full sm:w-3/5 p-5 sm:p-8 flex flex-col justify-center">
            <h3
              class="font-josefin-sans font-semibold text-xl sm:text-2xl text-gray-400"
            >
              Tunggu Kegiatan Lainnya
            </h3>
          </div>
        </div>
      </div>
    </section>
  </div>
  <section
    id="donate"
    class="-mx-6 lg:-mx-16 bg-[linear-gradient(135deg,#22c55e_0%,#14532d_100%)] py-14 sm:py-20"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="flex flex-col sm:flex-row items-center gap-8 sm:gap-12">
        <img
          src="{{ asset('images/about-us/about-us-2.jpeg') }}"
          alt="Donasi RTQ Ar-Rasyid"
          class="w-full h-56 sm:w-6/12 sm:h-80 md:sm:h-96 object-cover rounded-2xl shadow-xl shadow-green-900/40"
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
              href="{{ route('donations.index') }}"
              class="inline-block px-6 py-3 bg-green-600 text-gray-50 font-bold rounded-full hover:bg-green-600/90 hover:shadow-lg transition-all duration-200 text-base text-center sm:text-lg"
            >
              Donasi Via WA
            </a>
            <a
              href="{{ route('donations.index') }}"
              class="inline-block px-6 py-3 bg-white text-green-700 font-bold rounded-full hover:bg-green-50 hover:shadow-lg transition-all duration-200 text-base text-center sm:text-lg"
            >
              Donasi Langsung
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
