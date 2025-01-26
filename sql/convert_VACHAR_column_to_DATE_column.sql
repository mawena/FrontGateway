-- Étape 1 : Ajouter une nouvelle colonne temporaire de type DATE
ALTER TABLE ACVW_ALL_AC_ENTRIES ADD (TMP_VALUE_DT DATE);

-- Étape 2 : Copier et convertir les données dans la nouvelle colonne
UPDATE ACVW_ALL_AC_ENTRIES SET TMP_VALUE_DT = TO_DATE(VALUE_DT, 'DD/MM/YY'); -- Remplacez par le bon format de date

-- Étape 3 : Supprimer l'ancienne colonne
ALTER TABLE ACVW_ALL_AC_ENTRIES DROP COLUMN VALUE_DT;

-- Étape 4 : Renommer la nouvelle colonne pour qu'elle ait le même nom que l'ancienne colonne
ALTER TABLE ACVW_ALL_AC_ENTRIES RENAME COLUMN TMP_VALUE_DT TO VALUE_DT;