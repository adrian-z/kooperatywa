<?

include("funkcje.php");

polacz_z_baza();

print("Najblizsze zakupy: ");
print(nazwa_aktualnej_tury()." (".id_aktualnej_tury().")");

pokaz_uzyskane_ceny(id_aktualnej_tury()-1);


?>
