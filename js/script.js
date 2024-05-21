$(document).ready(function () {
  // menghilangkan tombol cari
  $("#tombol-cari").hide();

  // event ketika keyword ditulis
  // jquery carikan saya elemen keyword lalu .on ketika di keyup lakukan fungsi berikut ini
  $("#keyword").on("keyup", function () {
    // memunculkan icon loading/loader
    $(".loader").show();

    // ajax menggunakan load
    // jquery tolong carikan saya sebuah elemen bernama container lalu load/ubah isinya dengan data yang kita ambil dari sumber yaitu ajax/mhs
    // lalu kirimkan data keywordnya diisi dengan apapun yg diisikan user
    // $("#container").load("ajax/mahasiswa.php?keyword=" + $("#keyword").val());

    //$.get()
    // jadi setelah data diambil kita lakukan sesuatu sambil mengirimkan hasilnya, parameter data (menggantikan xhrresponsetext)
    $.get("ajax/mahasiswa.php?keyword=" + $("#keyword").val(), function (data) {
      $("#container").html(data);
      $(".loader").hide();
    });
  });
});
