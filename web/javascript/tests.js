/*global $, QUnit*/

$.getScript('/javascript/recipe.js', function () {
    "use strict";
    
    QUnit.test('create ingredient', function (assert) {
        var ingredient = new Ingredient('1/4', 'teaspoon', 'fresh basil', 'chopped');
        
        assert.strictEqual(ingredient.amount, 0.25);
        assert.strictEqual(ingredient.unit, 'teaspoon');
        assert.strictEqual(ingredient.name, 'fresh basil');
        assert.strictEqual(ingredient.note, 'chopped');
    });
});