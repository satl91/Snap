<!-- notifications -->
<?php echo $this->presenter->notification->show(); ?>

<div class="page-header">

	<h4>Asignar roles</h4>

</div>

<div class="row">

	<?php echo form_open('admin/user/roles', array('class' => 'form-horizontal')); ?>

		<div class="span6">

			<div class="control-group">

				<label for="users" class="control-label">Asignar rol a</label>

				<div class="controls">

					<select name="user[]" id="users" multiple="multiple" class="span4" style="height: 500px; overflow: auto">

						<optgroup label="Ingenium: Desarrollo Virtual">

							<option>Mario Cuba</option>
							<option>Nancy Reyes</option>
							<option>Luis Rodríguez</option>
							<option>Leonardo González</option>

						</optgroup>

						<optgroup label="Instituto Virtual de Estudios Avanzados">

							<option>José Rincón</option>
							<option>Nadia Padrón</option>

						</optgroup>

					</select>

				</div>

			</div>

			<div class="control-group">

				<label for="assign" class="control-label">Asignar rol de</label>

				<div class="controls">

					<div class="btn-group">

						<button class="btn btn-warning">Administrador</button>
						<button class="btn">Soporte Técnico</button>
						<button class="btn">Usuario</button>

					</div>

				</div>

			</div>

		</div>

		<div class="span5 offset1">

			<div class="row">

				<legend>Administradores</legend>

				<div class="span1">

					<div class="thumbnail">

						<?php echo $this->presenter->user->avatar(1, 64); ?>
					
					</div>

				</div>

				<div class="span4">

					<h4>Mario Cuba <small>Ingenium: Desarrollo Virtual</small></h4>

					<p><?php echo safe_mailto('mario.cuba@ingenium-dv.com'); ?></p>

				</div>

			</div>

			<!-- hax -->
			<div class="row">&nbsp;</div>
			<!-- endhax -->

			<div class="row">

				<legend>Soporte Técnico</legend>

				<ul>

					<li>Leonardo González</li>
					<li>Nancy Reyes</li>
					<li>Luis Rodríguez</li>

				</ul>

			</div>

		</div>

	<?php echo form_close(); ?>

</div>