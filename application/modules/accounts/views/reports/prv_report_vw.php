<div style="background-color: white;">
    <!-- First CN Slip Start -->
    <div style='padding-left: 70px; padding-right: 70px; width: 650px; height: 510px'><br />
		<table>
		    <tr>
		        <td  style="width: 300px;">
            		<img src="http://fte.com.pk/wp-content/uploads/2019/02/Card-1.png" width="250px;"  />
            		
		            
		        </td>
		        <td style="width: 150px;">
		            <h5 style="color: black;">TOLL FREE</h5>
            		<h5 style="color: black;">091 111 512 514</h5>
		        </td>
		        <td  style="width: 150px;">
		            <p style="font-size: 10px;">
		            Date of creation:  <?= $prvRecord['E_DATE_TIME'] ?> <br />
					Date of generation: <?php 
                            $timestamp = time(); 
                            echo(date("F d, Y h:i:s A", $timestamp)); 
                            ?> <br />
		            Website: https://fte.com.pk <br />
		            Email: info@fte.com.pk<br />
		            Phone No: 091-2572727</p>        
		        </td>
		    </tr>
		</table>
		
		<div  style="border-style: solid ;  border-width: 1px; padding: 10px;">
		<table >
			<tr>
				<td colspan="2"><h4 style="text-align: center; padding: 20px;">PAYMENT RECEIPT VOUCHER</h4></td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td  style="padding: 5px; width: 50%;">
					<span style="font-weight: bold; font-size: 18px;">PRV Number: </span> 	<label  style=" font-size: 18px;" id="lblproductName"><?= $prvRecord['PRV_ID'] ?></label>						
				</td>
				<td style="padding: 5px; width: 50%;">
					<span style="font-weight: bold; font-size: 18px;">Branch Name: </span>	<label  style=" font-size: 18px;" id="lblproductName"><?= $prvRecord['BRANCH_NAME'] ?></label>						
				</td>
				
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2" style="width: 100%; padding: 5px;">					
					<span  style="font-weight: bold; font-size: 18px;">Received with thanks from </span><label  style=" font-size: 18px; padding-left: 50px;" id="lblShipperName"><?= $prvRecord['RECEIVED_FROM']; ?></label><br />					
				</td>				
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2" style="width: 100%; padding: 5px;">
					<span style="font-weight: bold; font-size: 18px;">Received Amount </span><label  style=" font-size: 18px; padding-left: 50px;" id="lblreceiverName"><?= $prvRecord['RECEIVED_AMOUNT']; ?></label><br />															
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2" style="width: 100%; padding: 5px;">
					<span style="font-weight: bold; font-size: 18px;">On Account of </span><label  style=" font-size: 18px; padding-left: 50px;" id="lblreceiverName"><?= $prvRecord['ACCOUNT_OF']; ?></label><br />															
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2" style="width: 100%; padding: 5px;">
					<span style="font-weight: bold; font-size: 18px;">Type of PRV </span><label  style=" font-size: 18px; padding-left: 50px;" id="lblreceiverName"><?= $prvRecord['PRV_TYPE']; ?></label><br />															
				</td>
			</tr>
			<tr>
				<td style="width: 100px; padding: 20px;">
					<span style="font-weight: bold; font-size: 18px;">OFFICE COPY</span><br />		
					<span  style="font-weight: bold; font-size: 10px;">
						<strong>
							Generated: <?= $prvRecord['created_by']; ?><br>
							Updated: <?= $prvRecord['updated_by']; ?>
						</strong>
					</span>													
				</td>
				<td style="width: 600px;">
					<span style="font-weight: bold; font-size: 18px;">Receiver Signature: </span><br />															
				</td>
			</tr>
		</table>
		
		</div>
		<span style="font-size: 8px; text-align: center;">Note: <strong>NOT INSURED - INSURANCE OFFERED BUT REFUSED SENDER RISK, NO CLAIM, NO TIME LIMIT</strong>
		
	</div>
	<!-- First CN Slip End-->
</div>


<div style="background-color: white;">
    <!-- First CN Slip Start -->
    <div style='padding-left: 70px; padding-right: 70px; width: 650px; height: 510px'><br />
		<table>
		    <tr>
		        <td  style="width: 300px;">
            		<img src="http://fte.com.pk/wp-content/uploads/2019/02/Card-1.png" width="250px;"  />
            		
		            
		        </td>
		        <td style="width: 150px;">
		            <h5 style="color: black;">TOLL FREE</h5>
            		<h5 style="color: black;">091 111 512 514</h5>
		        </td>
		        <td  style="width: 150px;">
		            <p style="font-size: 10px;">
		            Date of creation:  <?= $prvRecord['E_DATE_TIME'] ?> <br />
					Date of generation: <?php 
                            $timestamp = time(); 
                            echo(date("F d, Y h:i:s A", $timestamp)); 
                            ?> <br />
		            Website: https://fte.com.pk <br />
		            Email: info@fte.com.pk<br />
		            Phone No: 091-2572727</p>        
		        </td>
		    </tr>
		</table>
		
		<div  style="border-style: solid ;  border-width: 1px; padding: 10px;">
		<table >
			<tr>
				<td colspan="2"><h4 style="text-align: center; padding: 20px;">PAYMENT RECEIPT VOUCHER</h4></td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td  style="padding: 5px; width: 50%;">
					<span style="font-weight: bold; font-size: 18px;">PRV Number: </span> 	<label  style=" font-size: 18px;" id="lblproductName"><?= $prvRecord['PRV_ID'] ?></label>						
				</td>
				<td style="padding: 5px; width: 50%;">
					<span style="font-weight: bold; font-size: 18px;">Branch Name: </span>	<label  style=" font-size: 18px;" id="lblproductName"><?= $prvRecord['BRANCH_NAME'] ?></label>						
				</td>
				
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2" style="width: 100%; padding: 5px;">					
					<span  style="font-weight: bold; font-size: 18px;">Received with thanks from </span><label  style=" font-size: 18px; padding-left: 50px;" id="lblShipperName"><?= $prvRecord['RECEIVED_FROM']; ?></label><br />					
				</td>				
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2" style="width: 100%; padding: 5px;">
					<span style="font-weight: bold; font-size: 18px;">Received Amount </span><label  style=" font-size: 18px; padding-left: 50px;" id="lblreceiverName"><?= $prvRecord['RECEIVED_AMOUNT']; ?></label><br />															
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2" style="width: 100%; padding: 5px;">
					<span style="font-weight: bold; font-size: 18px;">On Account of </span><label  style=" font-size: 18px; padding-left: 50px;" id="lblreceiverName"><?= $prvRecord['ACCOUNT_OF']; ?></label><br />															
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2" style="width: 100%; padding: 5px;">
					<span style="font-weight: bold; font-size: 18px;">Type of PRV </span><label  style=" font-size: 18px; padding-left: 50px;" id="lblreceiverName"><?= $prvRecord['PRV_TYPE']; ?></label><br />															
				</td>
			</tr>
			<tr>
				<td style="width: 100px; padding: 20px;">
					<span style="font-weight: bold; font-size: 18px;">CUSTOMER COPY</span><br />														
					<span  style="font-weight: bold; font-size: 10px;">
						<strong>
							Generated: <?= $prvRecord['created_by']; ?><br>
							Updated: <?= $prvRecord['updated_by']; ?>
						</strong>
					</span>
				</td>
				<td style="width: 600px;">
					<span style="font-weight: bold; font-size: 18px;">Receiver Signature: </span><br />		
				</td>
			</tr>
		</table>
		
		</div>
		<span style="font-size: 8px; text-align: center;">Note: <strong>NOT INSURED - INSURANCE OFFERED BUT REFUSED SENDER RISK, NO CLAIM, NO TIME LIMIT</strong>
		
	</div>
	<!-- First CN Slip End-->
</div>

<pre></pre>