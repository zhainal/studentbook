								<script>
									$(document).ready(function(){
										//Submit Start

										
										$("table tr td a.readmore").click(function(){
											var tr='<tr>'+$("table tr#master").html()+'</tr>';
											$("table tr#beforeadd").before(tr);
											return false;
										});
										
										$("#catatangurudataform").submit(function(e){
											if($('select#selrppiddetjenjangsiswa').val()==0){
												$('select#selrppiddetjenjangsiswa').css('border','1px solid red');
												return false;
											}else{
												$('select#selrppiddetjenjangsiswa').css('border','1px solid #D8D8D8');
											}
											$.ajax({
												type: "POST",
												data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&simpan=true'+'&'+$('form#catatanguruform').serialize()+'&tanggal='+$('input#datekirimcatatanguru').val(),
												url: $(this).attr('action'),
												beforeSend: function() {
													$("#simpancatatan").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
												},
												success: function(msg) {
													$("#wait").remove();	
													$.ajax({
															type: "POST",
															data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1&id_pembelajaran=<?=$id_pembelajaran?>&id_pelajaran=<?=$_POST['id_pelajaran']?>',
															url: '<?=base_url('akademik/perencanaan/sukses/PENILAIAN')?>',
															beforeSend: function() {
																$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
															},
															success: function(msg) {
																$("#wait").remove();
																$('#fancybox-content div').html(msg);
															}
														});
												}
											});
											return false;
										});
									});

									function up(thisobj){
										var poin=$(thisobj).prev().val();
										poin=parseInt(poin)+1;
										if(poin<6){
											$(thisobj).prev().val(poin);
										}
									}
									function down(thisobj){
										var poin=$($(thisobj).prev()).prev().val();
										poin=poin-1;
										if(poin>=1){
											$($(thisobj).prev()).prev().val(poin);
										}
									}
									
									
								</script>


								
								<form action="<?=base_url()?>akademik/perencanaan/penilaian" method="post" id="catatangurudataform" style="width:768px;height:100%;">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<table>
									<tbody>
										<tr>
											<td>
												<b>PENILAIAN DAN PENGAMATAN ASPEK YANG DIAMATI</b>
											</td>
										</tr>
									</tbody>
								</table>
								<table id="data">
										<thead>
											<tr>
												<th  colspan="4" style="padding: 0px; text-align: center; background: none repeat scroll 0% 0% transparent;">
													<input type="hidden" name="id_kelas" value="<?=$id_kelas?>" />
													<select name="id_det_jenjang" id="selrppiddetjenjangsiswa" >
														<option value="0" >Pilih Siswa Untuk Kelas <?=$nama_kelas?></option>
														<? foreach($siswa as $datasiswa){?>
														<option value="<?=$datasiswa['id_siswa_det_jenjang']?>" ><?=$datasiswa['nama']?></option>
														<? } ?>
													</select>
												</th>
											</tr>
											<tr>     
												<th>Aspek yang diamati</th>
												<th style="width:70px;">Nilai</th>
											</tr>                         
										</thead>
										<tbody>
										<? foreach($indikator as $dataindikator){?>
											<tr >
												<td ><?=$dataindikator['indikator']?></td>
												<td >
													
															<div style="position:relative;">
																<input class="poin" type="text" id="poin" style="border-radius:0;" name="poin[<?=$dataindikator['id']?>]" value="5">
																<span class="arrow-n2 up" onclick="up(this)"></span>
																<span class="arrow-s2 down" onclick="down(this)"></span>
															</div>
												</td>
												
											</tr>
											<? } ?>
											<tr id="beforeadd">
												<td align="right" colspan="3">
												<a title="" style="float:right;" class="readmorenoplus2" id="simpancatatan" onclick="$('#catatangurudataform').submit();"> Simpan </a>

												</td>
											</tr>
										</tbody>
								</table>
								</form>