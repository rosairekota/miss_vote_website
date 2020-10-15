<script src="https://www.paypal.com/sdk/js?client-id=ARihLWW7p_qff_fIs8w6Dzoxz_9KxNmlZa6SHBcAZLDn1vmID00O9pX2C6kZRLqVInLIT_Wys3C7W0Bs"></script>
<script>
	// 2. Afficher le bouton PayPal
	paypal.Buttons({

		// 3. Configurer la transaction
		createOrder : function (data, actions) {

			// Les produits à payer avec leurs details
			var produits = [
				{
					name : "Produit 1",
					description : "Description du produit 1",
					quantity : 1,
					unit_amount : { value : 9.9, currency_code : "USD" }
				},
				{
					name : "Produit 2",
					description : "Description du produit 2",
					quantity : 1,
					unit_amount : { value : 8.0, currency_code : "USD" }
				}
			];

			// Le total des produits
			var total_amount = produits.reduce(function (total, product) {
				return total + product.unit_amount.value * product.quantity;
			}, 0);

			// La transaction
			return actions.order.create({
				purchase_units : [{
					items : produits,
					amount : {
						value : total_amount,
						currency_code : "USD",
						breakdown : {
							item_total : { value : total_amount, currency_code : "USD" }
						}
					}
				}]
			});
		},

		// 4. Capturer la transaction après l'approbation de l'utilisateur
		onApprove : function (data, actions) {
			return actions.order.capture().then(function(details) {

				// Afficher Les details de la transaction dans la console
				console.log(details);

				// On affiche un message de succès
				alert(details.payer.name.given_name + ' ' + details.payer.name.surname + ', votre transaction est effectuée. Vous allez recevoir une notification très bientôt lorsque nous validons votre paiement.');

			});
		},

		// 5. Annuler la transaction
		onCancel : function (data) {
			alert("Transaction annulée !");
		}

	}).render("#paypal-boutons");

</script>
</body>
</html>
</script>