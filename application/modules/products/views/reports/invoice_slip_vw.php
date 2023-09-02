<?php
	// echo "<pre>";
	// print_r( $productRecord );
	// exit();
?>
<div style='padding-left: 70px; padding-right: 70px; width: 600px;'>
	<br />
	
	<span style="text-align: left; font-size: 24px;">Gift Performa Invoice</span><br />	<br />		
	
	<table  border="1">
		
		<tr>
		<td style="width: 300px; padding: 15px;">
		        <span style="text-align: left; font-size: 24px;">Shipper</span>
				<br />
				
				<label id="lblShipperName">
					<?= $productRecord[0]['SHIPPER_NAME']; ?>		
				</label>
				<br />
				
				
				<label id="lblShipperAddress">
					<?= $productRecord[0]['SHIPPER_ADDRESS'] ?>
				</label>
				<br />
				
				<label id="lblPhoneN0">
					<?= $productRecord[0]['SHIPPER_PHONE'] ?>
				</label>
				<br />
				<hr />
				<span style="text-align: left; font-size: 24px;">Receiver</span><br />
				<label id="lblReceiverName">
					<?= $productRecord[0]['CONSIGNEE_NAME']; ?>		
				</label>
				<br />
				
				
				
				<label id="lblReceiverAddress">
					<?= $productRecord[0]['CONSIGNEE_ADDRESS'] ?>		
				</label>
				<br />

				<label id="lblPhoneN0">
					<?= $productRecord[0]['CONSIGNEE_PHONE_NUMBER'] ?>		
				</label>
				<br />
			</td>
			<td style="width: 300px; padding: 15px;">
				<span style="font-weight: bold; font-size: 18px;">Date: </span><label id="lblDate"><?php 
                            $timestamp = time(); 
                            echo(date("F d, Y h:i:s A", $timestamp)); 
                            ?></label><br /><hr />
                <span style="font-weight: bold; font-size: 18px;">Product Name: </span><label id="lblProductName"><?= $productRecord[0]['ORDER_NAME'] ?></label><hr />
				<span style="font-weight: bold; font-size: 18px;">AWB No: </span><label id="lblCNNo"><?= $productRecord[0]['CN_NUMBER'] ?></label><br /><hr />
				<span style="font-weight: bold; font-size: 18px;">NIC: </span><label id="lblNIC"></label><br /><hr />
				<span style="font-weight: bold; font-size: 18px;">Weight: </span><label id="lblWeight"><?= $productRecord[0]['PRODUCT_GROSS_WEIGHT']; ?> </label>
			</td>
		</tr>
	</table><br /><br />
	<table  border="1">
	<tr>
		<th style="width: 70px; padding: 5px;">
			Quantity
		</th>
		<th style="width: 330px; padding: 5px;">
			Description
		</th>
		<th style="width: 100px; padding: 5px;">
			Unit Price
		</th>
		<th style="width: 100px; padding: 5px;">
			Sub Total
		</th>
	</tr>
	<tr style="height: 350px;" valign="top">
    	<td>
        	<table>
            	<?php
            	$totalPrice;
            
            	$subTotalPrice;
            	
            	$subTotalQuantity;
            
            	for ($i=0; $i < sizeOf($productRecord) ; $i++) 
            	{
            		$totalPrice =  $productRecord[$i]['QUANTITY'] * $productRecord[$i]['PRICE'];
            
            		if ( !empty( $productRecord[$i]['PRICE'] ) )
            		{
            			$productPrice = '$' . $productRecord[$i]['PRICE'];
            		}
            		else
            		{
            			$productPrice = '$0';
            		}
            	?>
            		<tr>
            			<td style="padding: 5px; ">
            				<label id="lblQuantityCounter">
            					<?= $productRecord[$i]['QUANTITY'] ?>	
            				</label>
            			</td>
            			
            		</tr>
            	<?php
            	}
            	?>
        	</table>
        </td>
        <td>
            <table>
            	<?php
            	$totalPrice;
            
            	$subTotalPrice;
            	
            	$subTotalQuantity;
            
            	for ($i=0; $i < sizeOf($productRecord) ; $i++) 
            	{
            		$totalPrice =  $productRecord[$i]['QUANTITY'] * $productRecord[$i]['PRICE'];
                    if ( !empty( $productRecord[$i]['PRICE'] ) )
            		{
            			$productPrice = '$' . $productRecord[$i]['PRICE'];
            		}
            		else
            		{
            			$productPrice = '$0';
            		}
            	?>
            		<tr>
            			
            			<td style="padding: 5px;">
            				<label id="lblDescription">
            					<?= $productRecord[$i]['PRODUCT_NAME'] ?>	
            				</label>
            			</td>
            			
            		</tr>
            	<?php
            	}
            	?>
        	</table>
        </td>
        <td>
            <table>
            	<?php
            	$totalPrice;
            
            	$subTotalPrice;
            	
            	$subTotalQuantity;
            
            	for ($i=0; $i < sizeOf($productRecord) ; $i++) 
            	{
            		$totalPrice =  $productRecord[$i]['QUANTITY'] * $productRecord[$i]['PRICE'];
                    if ( !empty( $productRecord[$i]['PRICE'] ) )
            		{
            			$productPrice = '$' . $productRecord[$i]['PRICE'];
            		}
            		else
            		{
            			$productPrice = '$0';
            		}
            	?>
            		<tr>
            			
            			<td style="padding: 5px;">
            				<label id="lblProductunitPrice">
            					<?= $productPrice ?>	
            				</label>
            			</td>
            			
            		</tr>
            	<?php
            	}
            	?>
        	</table>
        </td>
        <td>
            <table>
            	<?php
            	$totalPrice;
            
            	$subTotalPrice;
            	
            	$subTotalQuantity;
            
            	for ($i=0; $i < sizeOf($productRecord) ; $i++) 
            	{
            		$totalPrice =  $productRecord[$i]['QUANTITY'] * $productRecord[$i]['PRICE'];
            
            		@$subTotalPrice += $totalPrice;
            
            		@$subTotalQuantity += $productRecord[$i]['QUANTITY'];
            
            		if ( !empty( $productRecord[$i]['PRICE'] ) )
            		{
            			$productPrice = '$' . $productRecord[$i]['PRICE'];
            		}
            		else
            		{
            			$productPrice = '$0';
            		}
            	?>
            		<tr>
            			
            			<td style="padding: 5px;">
            				<label id="lblSubTotal">
            					<?= '$' . $totalPrice ?>	
            				</label>
            			</td>
            		</tr>
            	<?php
            	}
            	?>
        	</table>
        </td>
	</tr>
	</table><br />
	<table  border="1">
	<tr>
			<td style="width: 70px; padding: 5px;">
				<span>Total: </span>
				<label id="lblTotalItems">
					<?= $subTotalQuantity ?>	
				</label>
			</td>
			<td style="width: 430px; padding: 5px;">
			</td>
			<td style="width: 100px; padding: 5px;">
				<span>Total: </span>
				<label id="lblTotalItems">
					<?= '$' . $subTotalPrice ?>	
				</label>
			</td>
		</tr>
	</table>
		<span style="font-size: 12px;">CERTIFIED THAT THE GOODS MENTIONED IN THIS INOICE ARE OF PAKISTAN ORIGIN, GIFT ITEM HAVING NO COMMERCIAL VALUE, VALUE OF THE GOODS DECLARED IS CORRECT TO THE BEST OF MY BELIVE AND KNOWLEDGE. SUBJECT TO FTE TERMS AND CONDITION.</span>

	<hr />
	<table>
		<tr>
		<td style="width: 400px"><strong>Signature:</strong></td>
		<td style="width: 200px;"><strong>Stamp:</strong></td>
		</tr>
	</table>
	
</div>
  