// Store frame for motion functions
var previousFrame = 0;

//Booléen permettant de savoir si on doit afficher les informations sur la main
var displayData = true;

//Booléen pour savoir si le doigt est sorti de la zone de capture
var isFingerInZone1 = false;
var isFingerInZone2 = false;

//Booleen pour savoir si un doigt touche le rectangle
var isTouchingPlane1 = false;
var isTouchingPlane2 = false;

//ID de la dernière frame ayant permis de répondre oui ou non
var idLastFrame = 0;

//POSITIONS temporaires
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

var plane1;
var plane2;
var fingerLineSegment;
var circle;
var circle2;

 //Transforme un vecteur en chaîne pour l'affichage
function vectorToString(vector, digits)
{
    if (typeof digits === "undefined") 
        digits = 1;
    return "(" + vector[0].toFixed(digits) + ", " + vector[1].toFixed(digits) + ", " + vector[2].toFixed(digits) + ")";
}

function insertectInRectangle(positionsPoints,pointIntersec)
{
    var continu = true;

	//console.log("Point d'intersection : x = "+pointIntersec.stabilizedTipPosition[0]+", y = "+pointIntersec.stabilizedTipPosition[1]+", z = "+pointIntersec.stabilizedTipPosition[2]);
    if(pointIntersec.stabilizedTipPosition[0] >= minAxe(positionsPoints,"x") && pointIntersec.stabilizedTipPosition[0] <= maxAxe(positionsPoints,"x"))
    {
        if(pointIntersec.stabilizedTipPosition[1] >= minAxe(positionsPoints,"y") && pointIntersec.stabilizedTipPosition[1] <= maxAxe(positionsPoints,"y"))
        {
            if(pointIntersec.tipPosition[2] <= (maxAxe(positionsPoints,"z")+35))
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
	console.log("Creation du plan - Positions des angles du rectangle");
	console.log("TopLeft : x = "+positions.topLeft.x+", y = "+positions.topLeft.y+", z = "+positions.topLeft.z);
	console.log("TopRight : x = "+positions.topRight.x+", y = "+positions.topRight.y+", z = "+positions.topRight.z);
	console.log("BottomLeft : x = "+positions.bottomLeft.x+", y = "+positions.bottomLeft.y+", z = "+positions.bottomLeft.z);
	console.log("BottomRight : x = "+positions.bottomRight.x+", y = "+positions.bottomRight.y+", z = "+positions.bottomRight.z);
	
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

    return plane;

}

// Setup Leap loop with frame callback function
var controllerOptions = {enableGestures: true};

//Début de la boucle Leap.loop()
Leap.loop(controllerOptions, function(frame)
{
    if (previousFrame==frame.id)
        return; // Skip this update

	//console.log("Frame ID debut: " + frame.id);

    //Variable pour gerer l'affichage des informations des mains
    var handString = "<p>";
	
	handString += "<div class='col-md-12'><p>Main(s) détectée(s) : ";
	handString += frame.hands.length;
    handString += "</p></div>";
	
	//Affichage de la string dans la balise d'id handData
	var handOutput = document.getElementById("handData");   //Recherche de la div handData
    if(displayData)
        handOutput.innerHTML = handString;

    if (frame.hands.length > 0)  //Vrai si au moins une main est présente
    {
        for (var i = 0; i < frame.hands.length; i++)  //On itère sur le nombre de mains
        {
            var hand = frame.hands[i];  //On récupère la main i
			var fingerTouchingRectangle = 0;
			
            // IDs of pointables (fingers and tools) associated with this hand
            if (hand.pointables.length > 0)
            {
				for (var i = 0; i < hand.pointables.length; i++)  //On itère sur le nombre de doigts
				{
					if(insertectInRectangle(positions1,frame.pointables[i]))
					{
						console.log("if 1");
						isTouchingPlane1=true;
						isTouchingPlane2=false;
						fingerTouchingRectangle = i;
						i = hand.pointables.length;
						//return;
					}
					else if(insertectInRectangle(positions2,frame.pointables[i]))
					{
						console.log("if 2");
						isTouchingPlane2=true;
						isTouchingPlane1=false;
						fingerTouchingRectangle = i;
						i = hand.pointables.length;
						//return;
					}
					else
					{
						console.log("if 3");
						isTouchingPlane2=false;
						isTouchingPlane1=false;
					}
				}
				
				console.log("x = "+frame.pointables[fingerTouchingRectangle].stabilizedTipPosition[0]+", y = "+frame.pointables[fingerTouchingRectangle].stabilizedTipPosition[1]+", z= "+frame.pointables[fingerTouchingRectangle].tipPosition[2]);

				if(plane1 && isTouchingPlane1)
				{
					console.log("Finger is touching plane 1 at: ");
					relativeTouchPoint = {
						x: (frame.pointables[fingerTouchingRectangle].stabilizedTipPosition[0] - positions1.topLeft.x) / (positions1.topRight.x - positions1.topLeft.x),
						y: 1 - ( (frame.pointables[fingerTouchingRectangle].stabilizedTipPosition[1] - positions1.bottomLeft.y) / (positions1.topLeft.y - positions1.bottomLeft.y))
					};
					
					if(displayData)
					{
						circle1.attr("cx",relativeTouchPoint.x * 200);
						circle1.attr("cy",relativeTouchPoint.y * 200);
						rect1.attr("fill", "#798933");
					}
					
					if(frame.id > (idLastFrame+50) && !isFingerInZone1)
					{
						idLastFrame = frame.id;
						if(!displayData)
							touch_yes();
						isFingerInZone1 = true;
					}	
				}
				else
				{
					if(displayData)
						rect1.attr("fill", "#F7230C");
					isFingerInZone1 = false;
				}
                    
				if(plane2 && isTouchingPlane2)
                {
					console.log("Finger is touching plane 2 at: ");
					relativeTouchPoint = {
							x: (frame.pointables[fingerTouchingRectangle].stabilizedTipPosition[0] - positions2.topLeft.x) / (positions2.topRight.x - positions2.topLeft.x),
							y: 1 - ( (frame.pointables[fingerTouchingRectangle].stabilizedTipPosition[1] - positions2.bottomLeft.y) / (positions2.topLeft.y - positions2.bottomLeft.y))
					};
					
					if(displayData)
					{
						circle2.attr("cx",relativeTouchPoint.x * 200);
						circle2.attr("cy",relativeTouchPoint.y * 200);
						rect2.attr("fill", "#798933");
					}
						
					if(frame.id > (idLastFrame+50) && !isFingerInZone2)
					{
						isFingerInZone2 = true;
						idLastFrame = frame.id;
						if(!displayData)
							touch_no();
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
				{
					rect1.attr("fill", "#F7230C");
					rect2.attr("fill", "#F7230C");
				}
			}
        } //Fin boucle for itérant sur les mains
    }

    //Variables pour l'affichage du nombre de doigts
    var pointableString = "";

	pointableString += "<div class='col-md-12'><p>Doigt(s) détecté(s) : ";
	pointableString += frame.pointables.length;
    pointableString += "</p></div>";

    //Affichage des informations sur les doigts dans la div pointableDate
	if(displayData)
	{
		var pointableOutput = document.getElementById("pointableData");    //Recherche de la div pointableData
        pointableOutput.innerHTML = pointableString;
	}

    //Sauvegarde de la frame pour les fonctions de geste (translation, rotation, scale)
    previousFrame = frame.id;
	
	//console.log("Frame ID fin: " + frame.id);
})
//Fin de la fonction Leap.lop()