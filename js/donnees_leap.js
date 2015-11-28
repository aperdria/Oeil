// Store frame for motion functions
var previousFrame = null;
var paused = false;

//Booléen permettant de savoir si on doit afficher les informations sur la main
var displayData = false;

//Booléen pour savoir si le doigt est sorti de la zone de capture
var isFingerInZone1 = false;
var isFingerInZone2 = false;

//ID de la dernière frame ayant permis de répondre oui ou non
var idLastFrame = 0;

//POSITIONS temporireas
var positions = {
    topLeft : undefined,
    topRight: undefined,
    bottomLeft: undefined,
    bottomRight: undefined
};

//positions plan 1
var positions1 = {
    topLeft : undefined,
    topRight: undefined,
    bottomLeft: undefined,
    bottomRight: undefined
};

//position plan 2
var positions2 = {
    topLeft : undefined,
    topRight: undefined,
    bottomLeft: undefined,
    bottomRight: undefined
};

var intersectionPoint;
var relativeTouchPoint;
var relativeTouchPoint2;


var globalFrame;
var plane1;
var plane2;
var fingerLineSegment;
var circle;
var circle2;

 //Transforme un vecteur en chaîne pour l'affichage
function vectorToString(vector, digits)
{
    if (typeof digits === "undefined") {
        digits = 1;
    }
    return "(" + vector[0].toFixed(digits) + ", "
            + vector[1].toFixed(digits) + ", "
            + vector[2].toFixed(digits) + ")";
}

//Gère la mise en pause ou non de la capture de la part du Leap
function togglePause()
{
    paused = !paused;
}

function insertectInRectangle(positionsPoints,pointIntersec)
{
    var continu = true;

    if(pointIntersec.x >= minAxe(positionsPoints,"x") && pointIntersec.x <= maxAxe(positionsPoints,"x"))
    {
        if(pointIntersec.y >= minAxe(positionsPoints,"y") && pointIntersec.y <= maxAxe(positionsPoints,"y"))
        {
            if(pointIntersec.z >= (minAxe(positionsPoints,"z")-40) && pointIntersec.z <= (maxAxe(positionsPoints,"z")+10))
                continu = true;
            else
                continu = false;
        }
        else
            continu = false;
    }
    else
        continu = false;

    return continu;
}

function minAxe(positionsPoints,axe)
{
    var min;
    var y;
    var z;

    if(axe=="x")
    {
        min = Math.min(positionsPoints.topLeft.x, positionsPoints.bottomLeft.x);
    }
    else if(axe=="y")
    {
        min = Math.min(positionsPoints.bottomLeft.y, positionsPoints.bottomRight.y);
    }
    else if(axe=="z")
    {
        var y = Math.min(positionsPoints.topRight.z, positionsPoints.topLeft.z);
        var z = Math.min(positionsPoints.bottomRight.z, positionsPoints.bottomLeft.z);
        min = Math.min(z, y);
    }

    return min;
}

function maxAxe(positionsPoints,axe)
{
    var max;
    var y;
    var z;

    if(axe=="x")
    {
        max = Math.max(positionsPoints.topRight.x, positionsPoints.bottomRight.x);
    }
    else if(axe=="y")
    {
        max = Math.max(positionsPoints.topLeft.y, positionsPoints.topRight.y);
    }
    else if(axe=="z")
    {
        var y = Math.max(positionsPoints.topRight.z, positionsPoints.topLeft.z);
        var z = Math.max(positionsPoints.bottomRight.z, positionsPoints.bottomLeft.z);
        max = Math.max(z, y);
    }

    return max;
}

//Création du plan grâce à la librairie Three.js
function createPlane(plane,positions)
{
    var vectorCoords1 = {
        x: positions.topRight.x - positions.topLeft.x,
        y: positions.topRight.y - positions.topLeft.y,
        z: positions.topRight.z - positions.topLeft.z
    };

    var vectorCoords2 = {
        x: positions.topLeft.x - positions.bottomLeft.x,
        y: positions.topLeft.y - positions.bottomLeft.y,
        z: positions.topLeft.z - positions.bottomLeft.z
    };

    var v1 = new THREE.Vector3(vectorCoords1.x, vectorCoords1.y, vectorCoords1.z);
    var v2 = new THREE.Vector3(vectorCoords2.x, vectorCoords2.y, vectorCoords2.z);

    var normalVector = new THREE.Vector3();
    normalVector.crossVectors(v1,v2);

    var position1 = new THREE.Vector3(positions.topRight.x, positions.topRight.y, positions.topRight.z);
    plane = new THREE.Plane();

    plane.setFromNormalAndCoplanarPoint(normalVector, position1);

    console.log("create plane: " + plane);

    return plane;

}

//Retourne un segment correspondant au doigt (debut et fin)
function getFingerLineSegment(pointable)
{
    var length = 20;
    //Point de début du segment
    var start = new THREE.Vector3(
            pointable.stabilizedTipPosition[0] - length * pointable.direction[0],
            pointable.stabilizedTipPosition[1] - length * pointable.direction[1],
            pointable.stabilizedTipPosition[2] - length * pointable.direction[2]
    );

    //Point de fin du segment
    var end = new THREE.Vector3(
            pointable.stabilizedTipPosition[0] + length * pointable.direction[0],
            pointable.stabilizedTipPosition[1] + length * pointable.direction[1],
            pointable.stabilizedTipPosition[2] + length * pointable.direction[2]
    );

    fingerLineSegment = new THREE.Line3(start, end);
    return fingerLineSegment;
}


 // Setup Leap loop with frame callback function
var controllerOptions = {enableGestures: true};

//Début de la boucle Leap.loop()
Leap.loop(controllerOptions, function(frame)
{
    //Si en  pause on sort de Leap.loop(), on y reviendra quand pause sera remis à false
    if (paused)
        return; // Skip this update

    //sauvegarde de l'objet frame dans globalFrame
    globalFrame = frame;

    //Affichage des données de l'objet Frame
    var frameOutput = document.getElementById("frameData");   //Recherche de la div frameData
    var frameString = "Frame ID: " + frame.id  + "<br />"
            + "Hands: " + frame.hands.length + "<br />"
            + "Fingers: " + frame.fingers.length + "<br />"

    //Affichage de la string dans la balise d'id frameData
    if(displayData)
        frameOutput.innerHTML = "<p>" + frameString + "</p>";

    //Affichage des informations des mains
    var handOutput = document.getElementById("handData");   //Recherche de la div handData
    var handString = "";

    if (frame.hands.length > 0)  //Vrai si au moins une main est présente
    {
        for (var i = 0; i < frame.hands.length; i++)  //On itère sur le nombre de mains
        {
            var hand = frame.hands[i];  //On récupère la main i

            handString += "<p>";
            handString += "Hand ID: " + hand.id + "<br />";
            handString += "Direction: " + vectorToString(hand.direction, 2) + "<br />";


            // IDs of pointables (fingers and tools) associated with this hand
            if (hand.pointables.length > 0)
            {
                fingerVector = getFingerLineSegment(hand.pointables[0]);

                if(plane1 && plane1.isIntersectionLine(fingerLineSegment))
                {
                    intersectionPoint = plane1.intersectLine(fingerLineSegment);
                    relativeTouchPoint = {
                        x : (intersectionPoint.x - positions1.topLeft.x) / (positions1.topRight.x - positions1.topLeft.x),
                        y : 1  - ( (intersectionPoint.y - positions1.bottomLeft.y) / (positions1.topLeft.y - positions1.bottomLeft.y))
                    };

                    if(insertectInRectangle(positions1,intersectionPoint))
                    {
                        console.log("finger is touching plane 1 at: ");
                        if(displayData)
                        {
                            circle1.attr("cx",relativeTouchPoint.x * 200);
                            circle1.attr("cy",relativeTouchPoint.y * 200);
                            rect1.attr("fill", "#798933");
                        }
                        else
                        {
                            if(!isFingerInZone1 && (frame.id > (idLastFrame+50)))
                            {
                                idLastFrame = frame.id;
                                touch_yes();
                            }
                            isFingerInZone1 = true;
                        }
                    }
                    else
                    {
                        if(displayData)
                            rect1.attr("fill", "#F7230C");
                        isFingerInZone1 = false;
                    }


                }
                else
                {
                    if(displayData)
                        rect1.attr("fill", "#F7230C");
                    isFingerInZone1 = false;
                }

                //  if(plane2){
                if(plane2 && plane2.isIntersectionLine(fingerLineSegment))
                {
                    intersectionPoint = plane2.intersectLine(fingerLineSegment);
                    relativeTouchPoint = {
                        x: (intersectionPoint.x - positions2.topLeft.x) / (positions2.topRight.x - positions2.topLeft.x),
                        y: 1 - ( (intersectionPoint.y - positions2.bottomLeft.y) / (positions2.topLeft.y - positions2.bottomLeft.y))
                    };


                    if(insertectInRectangle(positions2,intersectionPoint))
                    {
                        console.log("finger is touching plane 2 at: ");
                        if(displayData)
                        {
                            circle2.attr("cx",relativeTouchPoint.x * 200);
                            circle2.attr("cy",relativeTouchPoint.y * 200);
                            rect2.attr("fill", "#798933");
                        }
                        else
                        {
                            if(!isFingerInZone2 && (frame.id > (idLastFrame+50)))
                            {
                                idLastFrame = frame.id;
                                touch_no();
                            }
                            isFingerInZone2 = true;
                        }
                    }
                    else
                    {
                        if(displayData)
                            rect2.attr("fill", "#F7230C");
                        isFingerInZone2 = false;
                    }
                }
                else
                {
                    if(displayData)
                        rect2.attr("fill", "#F7230C");
                    isFingerInZone2 = false;
                }

                var fingerIds = [];
                for (var j = 0; j < hand.pointables.length; j++) 
                {
                    var pointable = hand.pointables[j];
                    fingerIds.push(pointable.id);
                    
                }
                if (fingerIds.length > 0) {
                    handString += "Fingers IDs: " + fingerIds.join(", ") + "<br />";
                }
            }

            handString += "</div>";
        } //Fin boucle for itérant sur les mains
    }
    else
    {
        //Aucune main n'a été détectée
        handString += "No hands";
    }
    //Affichage de la string dans la balise d'id handData
    if(displayData)
        handOutput.innerHTML = handString;

    //Affichage des informations des doigts et des outils
    var pointableOutput = document.getElementById("pointableData");    //Recherche de la div pointableData
    var pointableString = "";

    //Nombre de doigts
    var nbFingers = 0;

    if (frame.pointables.length > 0) //Si on a détecté des doigts
    {
        pointableString += "<div class='col-md-6 nopadding'><p>";
        for (var i = 0; i < frame.pointables.length; i=i+2) //Itération sur les doigts pairs
        {
            var pointable = frame.pointables[i];

            pointableString += "<p>";

            pointableString += "Pointable ID: " + pointable.id + "<br />";
            pointableString += "Belongs to hand with ID: " + pointable.handId + "<br />";
            pointableString += "Direction: " + vectorToString(pointable.direction, 2) + "<br />";
            pointableString += "</p>";
            if((i+1) != frame.pointables.length)
                 pointableString += "</br>";

        }
        pointableString += "</div>";

        pointableString += "<div class='col-md-6 nopadding'><p>";
        
        if(frame.pointables.length>1)
        {
            for (var i = 1; i < frame.pointables.length; i = i+2) //Itération sur les doigts pairs
            {
                var pointable = frame.pointables[i];

                pointableString += "<p>";

                pointableString += "Pointable ID: " + pointable.id + "<br />";
                pointableString += "Belongs to hand with ID: " + pointable.handId + "<br />";
                pointableString += "Direction: " + vectorToString(pointable.direction, 2) + "<br />";
                pointableString += "</p>";
                if((i+1) != frame.pointables.length)
                     pointableString += "</br>";

            }
        }
        pointableString += "</div>";
    }
    else
    {
        //Aucun doigts détectés
        pointableString += "<div>No pointables</div>";
    }
    //Affichage des informations sur les doigts dans la div pointableDate
    if(displayData)
        pointableOutput.innerHTML = pointableString;

    //Sauvegarde de la frame pour les fonctions de geste (translation, rotation, scale)
    previousFrame = frame;
})
//Fin de la fonction Leap.lop()