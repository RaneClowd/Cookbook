/*global math*/

function Ingredient(amountStr, unit, name, note) {
    "use strict";
    
    this.name = name;
    this.note = note;
    
    this.amount = math.eval(amountStr);
    
    if (unit !== "--") {
        this.unit = unit;
    }
}