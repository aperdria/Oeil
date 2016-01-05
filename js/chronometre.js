function heure() { 
 temps++; base=temps;
 cs=base % 100;
 base=(temps-cs) / 100;
 s=base % 60;
 m=(base-s) / 60; 
 texte=""; 
 if (m<10) texte=texte+"0"; texte=texte+m+":"; 
 if (s<10) texte=texte+"0"; texte=texte+s+":";
 if (cs<10) texte=texte+"0"; texte=texte+cs;
 document.formu.cadran.value=texte; 
} 
function commence() { 
 temps=-1; heure();
 document.formu.bouton.value="STOP";
 chrono=setInterval("heure()",10); 
} 
function stoppe() {
 if (chrono!=null) clearInterval(chrono);
 chrono=null;
 document.formu.bouton.value="DEPART";
}  
function clique() {
 if (chrono==null) commence(); else stoppe();
} 
