
<?php
// insertdonasi.php
include 'connection.php';

// langkah-langkah prepare > bind > execute

$conn = getConnection();

try {
    if($_POST){
        $nim = $_POST["nim"];
        $nama = $_POST["nama"];
        $kelas = $_POST["kelas"];
        $jurusan = $_POST["jurusan"];
        $angkatan = $_POST["angkatan"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $umur = $_POST["umur"];
        $alamat = $_POST["alamat"];

        if(isset($_FILES["pas_photo"]["name"])){
            $image_name = $_FILES["pas_photo"]["name"];
            $extensions = ["jpg", "png", "jpeg"];
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);

            if (in_array($extension, $extensions)){
                $upload_path = 'upload/' . $image_name;

                if(move_uploaded_file($_FILES["pas_photo"]["tmp_name"], $upload_path)){

                    $pas_photo = "http://localhost/belajarbackend/" . $upload_path;

                    $statement = $conn->prepare("INSERT INTO `mahasiswa`( `nim`, `nama`, `kelas`, `jurusan`, `angkatan`, `tanggal_lahir`, `jenis_kelamin`, `umur`, `alamat`, `pas_photo`) 
                    VALUES (:nim, :nama, :kelas, :jurusan, :angkatan, :tanggal_lahir, :jenis_kelamin, :umur, :alamat, :pas_photo);");

                    $statement->bindParam(':nim', $nim);
                    $statement->bindParam(':nama',$nama);
                    $statement->bindParam(':kelas',$kelas);
                    $statement->bindParam(':jurusan',$jurusan);
                    $statement->bindParam(':angkatan', $angkatan);
                    $statement->bindParam(':tanggal_lahir',$tanggal_lahir);
                    $statement->bindParam(':jenis_kelamin',$jenis_kelamin);
                    $statement->bindParam(':umur',$umur);
                    $statement->bindParam(':alamat',$alamat);
                    $statement->bindParam(':pas_photo',$pas_photo);

                    $statement->execute();

                    $response["message"] = "Data Berhasil Direcord!";

                } else {
                    echo "gagal memindahkan file";
                }
            } else {
                $response["message"] = "Hanya diperbolehkan menginput keterangan gambar!";
            }

        } else {
            $statement = $conn->prepare("INSERT INTO `mahasiswa`( `nim`, `nama`, `kelas`, `jurusan`, `angkatan`, `tanggal_lahir`, `jenis_kelamin`, `umur`, `alamat`) 
                    VALUES (:nim, :nama, :kelas, :jurusan, :angkatan, :tanggal_lahir, :jenis_kelamin, :umur, :alamat);");

            $statement->bindParam(':nim', $nim);
            $statement->bindParam(':nama',$nama);
            $statement->bindParam(':kelas',$kelas);
            $statement->bindParam(':jurusan',$jurusan);
            $statement->bindParam(':angkatan', $angkatan);
            $statement->bindParam(':tanggal_lahir',$tanggal_lahir);
            $statement->bindParam(':jenis_kelamin',$jenis_kelamin);
            $statement->bindParam(':umur',$umur);
            $statement->bindParam(':alamat',$alamat);

            $statement->execute();
            $response["message"] = "Data berhasil direcord";
        }
    }
} catch (PDOException $e){
    $response["message"] = "error $e";
}
echo json_encode($response, JSON_PRETTY_PRINT);
?>