async function search_ville_name_by_cp(cp){


  let code_postal = document.getElementById(cp).value;

  if ((code_postal).length==5){

    let url ='https://geo.api.gouv.fr/communes?codePostal='+code_postal;

    let response = await fetch(url);
    let json = await response.json();

    if (json.length!=0){
      for(var i=0; i<json.length;i++ ){
        document.getElementById('ville').innerHTML += "<option>"+json[i].nom;
      }
    }
  }
  else{
    document.getElementById('ville').innerHTML ="";
  }

}
