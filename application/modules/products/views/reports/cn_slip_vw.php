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
		            Date: <?php 
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
			
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2"  style="padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Tracking ID: </span>	<label  style=" font-size: 12px;" id="lblproductName" style="font-size: 12px;"><?= $productRecord['CN_NUMBER'] ?></label>						
				</td>
				
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">					
					<span  style="font-weight: bold; font-size: 12px;">Shipper Name: </span><label  style=" font-size: 12px;" id="lblShipperName"><?= $productRecord['SHIPPER_NAME']; ?></label><br />					
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Name: </span><label  style=" font-size: 12px;" id="lblreceiverName"><?= $productRecord['CONSIGNEE_NAME']; ?></label><br />					
										
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Address: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_ADDRESS']; ?></label><br />
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Adress: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_ADDRESS']; ?></label><br />
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper City: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_CITY']; ?></label><br />
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver City: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_CITY']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style="font-weight: bold; font-size: 12px;">State: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_STATE']; ?></label><br />
					
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Country: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_COUNTRY']; ?></label>
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Country: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_COUNTRY']; ?></label>&nbsp;&nbsp;
					<span style="font-weight: bold; font-size: 12px;">ZipCode: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_ZIP_CODE']; ?></label>
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px;  padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Phone: </span><label  style=" font-size: 12px;" id="lblShipperPhone"><?= $productRecord['SHIPPER_PHONE']; ?></label><br />				
									
				</td>
				<td style="width: 300px;  padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Phone: </span><label  style=" font-size: 12px;" id="lblreceiverPhone"><?= $productRecord['CONSIGNEE_PHONE_NUMBER']; ?></label><br />				
				</td>				
			</tr>
			
			
		</table>
		
		<table>
			<tr>
				<td style="width: 200px;">
					<span style="font-size: 10px;">Product Name: </span><label  style="font-size: 10px; font-weight: bold;" id="lblproductName"><?= $productRecord['PRODUCT_NAME']; ?></label><br />	
					
					<span style="font-size: 10px;">Weight: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverName"><?= $productRecord['PRODUCT_GROSS_WEIGHT']; ?></label><br />	
					<span style="font-size: 10px;">NetWeight: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverPhone"><?= $productRecord['PRODUCT_NET_WEIGHT']; ?></label><br />
					<span style="font-size: 10px;">Dimension: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['PRODUCT_DIMENSION']; ?></label><br />
					<span style="font-size: 10px;">No of Pieces: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['QUANTITY']; ?></label><br />
					<span style="font-size: 10px;">Balance Amount: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['BALANCE_AMOUNT']; ?></label><br />
					
					<span style="font-size: 14px;">BOOKING OFFICE COPY</span>
				</td>
				<td style="width: 400px;">
				    <label id="lblDescription"><p  style="font-size: 8px; line-height: 8px;"><strong>Description:</strong> <?= $productRecord['DESCRIPTION']; ?></p></label>
					<p style="font-size: 10px;">UNLESS OTHERWISE AGREED IN WRITING I/WE AGREE THAT ETC, TERMS AND CONDITIONS OF CARRIAGE AREALL THE TERMS OF THE CONTRACT BETWEEN ME/US & FTE &
(1) SUCH TERM AND CONDITIONS & WHERE APPLICABLE THE WARSAM CONVETION LIMITS &/OR EXCLUDES FTE. LIABILITY FOR THE LOSS-DAMAGE OR DELAY &
(2) THIS SHIPMINT DEOS NOT CONTAIN CASH OR DANGEROUS GOODS OR ANY PROHIBITED ITEMS PLEASE READ CAREFULLY AND UNDERSTOOD THE STANDARD TERMS AND CONDITIONS OF FTE AS PRINITED ON THE TERMS AND CONDITION PAGE.</p>
					
					<h6>Shipper Signature: __________________________&nbsp;&nbsp;Bill Amount: <label><?= $productRecord['CONSIGNEE_AMOUNT']; ?></label></h6>
				</td>
			</tr>
			
			
		</table>
		
		</div>
		<span style="font-size: 8px; text-align: center;">Note: <strong>NOT INSURED - INSURANCE OFFERED BUT REFUSED SENDER RISK, NO CLAIM, NO TIME LIMIT</strong> <br /> <strong>Generated: <?= $productRecord['GENERATED_BY']; ?>,&nbsp;&nbsp;   Updated: <?= $productRecord['UPDATED_BY']; ?></strong></span>
		
	</div>
	<!-- First CN Slip End-->
	<!-- 2nd CN Slip Start-->
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
		            Date: <?php 
                            $timestamp = time(); 
                            echo(date("F d, Y h:i:s A", $timestamp)); 
                            ?><br />
		            Website: https://fte.com.pk <br />
		            Email: info@fte.com.pk<br />
		            Phone No: 091-2572727</p>        
		        </td>
		    </tr>
		</table>
		
		<div  style="border-style: solid ;  border-width: 1px; padding: 10px;">
		<table >
			
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2"  style="padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Tracking ID: </span>	<label  style=" font-size: 12px;" id="lblproductName" style="font-size: 12px;"><?= $productRecord['CN_NUMBER'] ?></label>						
				</td>
				
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">					
					<span  style="font-weight: bold; font-size: 12px;">Shipper Name: </span><label  style=" font-size: 12px;" id="lblShipperName"><?= $productRecord['SHIPPER_NAME']; ?></label><br />					
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Name: </span><label  style=" font-size: 12px;" id="lblreceiverName"><?= $productRecord['CONSIGNEE_NAME']; ?></label><br />					
										
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Address: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_ADDRESS']; ?></label><br />
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Adress: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_ADDRESS']; ?></label><br />
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper City: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_CITY']; ?></label><br />
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver City: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_CITY']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style="font-weight: bold; font-size: 12px;">State: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_STATE']; ?></label><br />
					
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Country: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_COUNTRY']; ?></label>
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Country: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_COUNTRY']; ?></label>&nbsp;&nbsp;
					<span style="font-weight: bold; font-size: 12px;">ZipCode: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_ZIP_CODE']; ?></label>
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px;  padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Phone: </span><label  style=" font-size: 12px;" id="lblShipperPhone"><?= $productRecord['SHIPPER_PHONE']; ?></label><br />				
									
				</td>
				<td style="width: 300px;  padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Phone: </span><label  style=" font-size: 12px;" id="lblreceiverPhone"><?= $productRecord['CONSIGNEE_PHONE_NUMBER']; ?></label><br />				
				</td>				
			</tr>
			
			
		</table>
		
		<table>
			<tr>
				<td style="width: 200px;">
					<span style="font-size: 10px;">Product Name: </span><label  style="font-size: 10px; font-weight: bold;" id="lblproductName"><?= $productRecord['PRODUCT_NAME']; ?></label><br />	
					
					<span style="font-size: 10px;">Weight: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverName"><?= $productRecord['PRODUCT_GROSS_WEIGHT']; ?></label><br />	
					<span style="font-size: 10px;">NetWeight: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverPhone"><?= $productRecord['PRODUCT_NET_WEIGHT']; ?></label><br />
					<span style="font-size: 10px;">Dimension: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['PRODUCT_DIMENSION']; ?></label><br />
					<span style="font-size: 10px;">No of Pieces: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['QUANTITY']; ?></label><br />
					<span style="font-size: 10px;">Balance Amount: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['BALANCE_AMOUNT']; ?></label><br />
					<span style="font-size: 14px;">RECEIVER'S COPY</span>
				</td>
				<td style="width: 400px;">
				    <label id="lblDescription"><p  style="font-size: 8px; line-height: 8px;"><strong>Description:</strong> <?= $productRecord['DESCRIPTION']; ?></p></label>

					<p style="font-size: 10px;">UNLESS OTHERWISE AGREED IN WRITING I/WE AGREE THAT ETC, TERMS AND CONDITIONS OF CARRIAGE AREALL THE TERMS OF THE CONTRACT BETWEEN ME/US & FTE &
(1) SUCH TERM AND CONDITIONS & WHERE APPLICABLE THE WARSAM CONVETION LIMITS &/OR EXCLUDES FTE. LIABILITY FOR THE LOSS-DAMAGE OR DELAY &
(2) THIS SHIPMINT DEOS NOT CONTAIN CASH OR DANGEROUS GOODS OR ANY PROHIBITED ITEMS PLEASE READ CAREFULLY AND UNDERSTOOD THE STANDARD TERMS AND CONDITIONS OF FTE AS PRINITED ON THE TERMS AND CONDITION PAGE.</p>
					
					<h6>Shipper Signature: __________________________&nbsp;&nbsp;Bill Amount: <label><?= $productRecord['CONSIGNEE_AMOUNT']; ?></label></h6>
				</td>
			</tr>
		</table>
		</div>
		<span style="font-size: 8px; text-align: center;">Note: <strong>NOT INSURED - INSURANCE OFFERED BUT REFUSED SENDER RISK, NO CLAIM, NO TIME LIMIT</strong> <br /> <strong>Generated: <?= $productRecord['GENERATED_BY']; ?>,&nbsp;&nbsp;   Updated: <?= $productRecord['UPDATED_BY']; ?></strong></span>
		
	</div>
	<!-- 2nd CN Slip end-->
</div>

<div style="height: 1000px;">
    <!-- 3rd CN Slip Start-->
    <div style='padding-left: 70px; padding-right: 70px; width: 650px; height: 510px'>
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
		            Date: <?php 
                            $timestamp = time(); 
                            echo(date("F d, Y h:i:s A", $timestamp)); 
                            ?><br />
		            Website: https://fte.com.pk <br />
		            Email: info@fte.com.pk<br />
		            Phone No: 091-2572727</p>        
		        </td>
		    </tr>
		</table>
		
		<div  style="border-style: solid ;  border-width: 1px; padding: 10px;">
		<table >
			
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2"  style="padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Tracking ID: </span>	<label  style=" font-size: 12px;" id="lblproductName" style="font-size: 12px;"><?= $productRecord['CN_NUMBER'] ?></label>						
				</td>
				
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">					
					<span  style="font-weight: bold; font-size: 12px;">Shipper Name: </span><label  style=" font-size: 12px;" id="lblShipperName"><?= $productRecord['SHIPPER_NAME']; ?></label><br />					
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Name: </span><label  style=" font-size: 12px;" id="lblreceiverName"><?= $productRecord['CONSIGNEE_NAME']; ?></label><br />					
										
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Address: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_ADDRESS']; ?></label><br />
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Adress: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_ADDRESS']; ?></label><br />
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper City: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_CITY']; ?></label><br />
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver City: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_CITY']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style="font-weight: bold; font-size: 12px;">State: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_STATE']; ?></label><br />
					
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Country: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_COUNTRY']; ?></label>
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Country: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_COUNTRY']; ?></label>&nbsp;&nbsp;
					<span style="font-weight: bold; font-size: 12px;">ZipCode: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_ZIP_CODE']; ?></label>
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px;  padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Phone: </span><label  style=" font-size: 12px;" id="lblShipperPhone"><?= $productRecord['SHIPPER_PHONE']; ?></label><br />				
									
				</td>
				<td style="width: 300px;  padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Phone: </span><label  style=" font-size: 12px;" id="lblreceiverPhone"><?= $productRecord['CONSIGNEE_PHONE_NUMBER']; ?></label><br />				
				</td>				
			</tr>
			
			
		</table>
		
		<table>
			<tr>
				<td style="width: 200px;">
					<span style="font-size: 10px;">Product Name: </span><label  style="font-size: 10px; font-weight: bold;" id="lblproductName"><?= $productRecord['PRODUCT_NAME']; ?></label><br />	
					
					<span style="font-size: 10px;">Weight: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverName"><?= $productRecord['PRODUCT_GROSS_WEIGHT']; ?></label><br />	
					<span style="font-size: 10px;">NetWeight: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverPhone"><?= $productRecord['PRODUCT_NET_WEIGHT']; ?></label><br />
					<span style="font-size: 10px;">Dimension: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['PRODUCT_DIMENSION']; ?></label><br />
					<span style="font-size: 10px;">No of Pieces: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['QUANTITY']; ?></label><br />
					<span style="font-size: 10px;">Balance Amount: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['BALANCE_AMOUNT']; ?></label><br />
					<span style="font-size: 14px;">CUSTOMER COPY</span>
				</td>
				<td style="width: 400px;">
				    <label id="lblDescription"><p  style="font-size: 8px; line-height: 8px;"><strong>Description:</strong> <?= $productRecord['DESCRIPTION']; ?></p></label>

					<p style="font-size: 10px;">UNLESS OTHERWISE AGREED IN WRITING I/WE AGREE THAT ETC, TERMS AND CONDITIONS OF CARRIAGE AREALL THE TERMS OF THE CONTRACT BETWEEN ME/US & FTE &
(1) SUCH TERM AND CONDITIONS & WHERE APPLICABLE THE WARSAM CONVETION LIMITS &/OR EXCLUDES FTE. LIABILITY FOR THE LOSS-DAMAGE OR DELAY &
(2) THIS SHIPMINT DEOS NOT CONTAIN CASH OR DANGEROUS GOODS OR ANY PROHIBITED ITEMS PLEASE READ CAREFULLY AND UNDERSTOOD THE STANDARD TERMS AND CONDITIONS OF FTE AS PRINITED ON THE TERMS AND CONDITION PAGE.</p>
					
					<h6>Shipper Signature: __________________________&nbsp;&nbsp;Bill Amount: <label><?= $productRecord['CONSIGNEE_AMOUNT']; ?></label></h6>
				</td>
			</tr>
		</table>
		</div>
		
		<span style="font-size: 8px; text-align: center;">Note: <strong>NOT INSURED - INSURANCE OFFERED BUT REFUSED SENDER RISK, NO CLAIM, NO TIME LIMIT</strong> <br /> <strong>Generated: <?= $productRecord['GENERATED_BY']; ?>, &nbsp;&nbsp;  Updated: <?= $productRecord['UPDATED_BY']; ?></strong></span>
	</div>
	<!-- 3rd CN Slip End-->
	<!-- 4th CN Slip Start-->
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
		            Date: <?php 
                            $timestamp = time(); 
                            echo(date("F d, Y h:i:s A", $timestamp)); 
                            ?><br />
		            Website: https://fte.com.pk <br />
		            Email: info@fte.com.pk<br />
		            Phone No: 091-2572727</p>        
		        </td>
		    </tr>
		</table>
		
		<div  style="border-style: solid ;  border-width: 1px; padding: 10px;">
		<table >
			
			<tr style="border-bottom: 1px dotted;">
				<td colspan="2"  style="padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Tracking ID: </span>	<label  style=" font-size: 12px;" id="lblproductName" style="font-size: 12px;"><?= $productRecord['CN_NUMBER'] ?></label>						
				</td>
				
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">					
					<span  style="font-weight: bold; font-size: 12px;">Shipper Name: </span><label  style=" font-size: 12px;" id="lblShipperName"><?= $productRecord['SHIPPER_NAME']; ?></label><br />					
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Name: </span><label  style=" font-size: 12px;" id="lblreceiverName"><?= $productRecord['CONSIGNEE_NAME']; ?></label><br />					
										
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Address: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_ADDRESS']; ?></label><br />
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Adress: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_ADDRESS']; ?></label><br />
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper City: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_CITY']; ?></label><br />
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver City: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_CITY']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span style="font-weight: bold; font-size: 12px;">State: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_STATE']; ?></label><br />
					
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Country: </span><label  style=" font-size: 12px;" id="lblShipperAddress"><?= $productRecord['SHIPPER_COUNTRY']; ?></label>
				</td>
				<td style="width: 300px; padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Country: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_COUNTRY']; ?></label>&nbsp;&nbsp;
					<span style="font-weight: bold; font-size: 12px;">ZipCode: </span><label  style=" font-size: 12px;" id="lblreceiverAddress"><?= $productRecord['CONSIGNEE_ZIP_CODE']; ?></label>
				</td>
			</tr>
			<tr style="border-bottom: 1px dotted;">
				<td style="width: 300px;  padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Shipper Phone: </span><label  style=" font-size: 12px;" id="lblShipperPhone"><?= $productRecord['SHIPPER_PHONE']; ?></label><br />				
									
				</td>
				<td style="width: 300px;  padding: 5px;">
					<span style="font-weight: bold; font-size: 12px;">Receiver Phone: </span><label  style=" font-size: 12px;" id="lblreceiverPhone"><?= $productRecord['CONSIGNEE_PHONE_NUMBER']; ?></label><br />				
				</td>				
			</tr>
			
			
		</table>
		
		<table>
			<tr>
				<td style="width: 200px;">
					<span style="font-size: 10px;">Product Name: </span><label  style="font-size: 10px; font-weight: bold;" id="lblproductName"><?= $productRecord['PRODUCT_NAME']; ?></label><br />	
					
					<span style="font-size: 10px;">Weight: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverName"><?= $productRecord['PRODUCT_GROSS_WEIGHT']; ?></label><br />	
					<span style="font-size: 10px;">NetWeight: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverPhone"><?= $productRecord['PRODUCT_NET_WEIGHT']; ?></label><br />
					<span style="font-size: 10px;">Dimension: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['PRODUCT_DIMENSION']; ?></label><br />
					<span style="font-size: 10px;">No of Pieces: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['QUANTITY']; ?></label><br />
					<span style="font-size: 10px;">Balance Amount: </span><label style="font-size: 10px; font-weight: bold;" id="lblreceiverEmail"><?= $productRecord['BALANCE_AMOUNT']; ?></label><br />
					<span style="font-size: 14px;">ACCOUNTS COPY</span>
				</td>
				<td style="width: 400px;">
				    <label id="lblDescription"><p  style="font-size: 8px; line-height: 8px;"><strong>Description:</strong> <?= $productRecord['DESCRIPTION']; ?></p></label>

					<p style="font-size: 10px;">UNLESS OTHERWISE AGREED IN WRITING I/WE AGREE THAT ETC, TERMS AND CONDITIONS OF CARRIAGE AREALL THE TERMS OF THE CONTRACT BETWEEN ME/US & FTE &
(1) SUCH TERM AND CONDITIONS & WHERE APPLICABLE THE WARSAM CONVETION LIMITS &/OR EXCLUDES FTE. LIABILITY FOR THE LOSS-DAMAGE OR DELAY &
(2) THIS SHIPMINT DEOS NOT CONTAIN CASH OR DANGEROUS GOODS OR ANY PROHIBITED ITEMS PLEASE READ CAREFULLY AND UNDERSTOOD THE STANDARD TERMS AND CONDITIONS OF FTE AS PRINITED ON THE TERMS AND CONDITION PAGE.</p>
					
					<h6>Shipper Signature: __________________________&nbsp;&nbsp;Billed Amount: <label><?= $productRecord['CONSIGNEE_AMOUNT']; ?></label></h6>
				</td>
			</tr>
		</table>
		</div>
		<span style="font-size: 8px; text-align: center;">Note: <strong>NOT INSURED - INSURANCE OFFERED BUT REFUSED SENDER RISK, NO CLAIM, NO TIME LIMIT</strong> <br /> <strong>Generated: <?= $productRecord['GENERATED_BY']; ?>, &nbsp;&nbsp;  Updated: <?= $productRecord['UPDATED_BY']; ?></strong></span>
		
	</div>
	<!-- 4th CN Slip End-->
</div>