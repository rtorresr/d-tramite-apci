<header>
    <table>
        <tr id="logoMin">
            <td id="peruLogo" class="center" style="heigth: 50px; width: 50px; border:solid white 1.0pt; background:white;">
                <img width="34" src="../../dist/images/peru.png">
            </td>
            <td id="peruText" class="center minText" width="150" style="heigth: 50px; width: 50px; border:solid white 1.0pt;background:#C00000;">
                <p>PERÚ</p>
            </td>
            <td class="minText" width="151" style="heigth: 50px; width: 150px;border:solid white 1.0pt;border-left:none; background:#333333;">
                <p>Ministerio <br> de Relaciones Exteriores</p>
            </td>
            <td class="minText" width="180" style="heigth: 50px; width: 150px;border:solid white 1.0pt;border-left:  none;  background:#999999;">
                <p>Agencia Peruana <br> de Cooperación Internacional</p>
            </td>

            <td class="minText" width="151" style="heigth: 50px; width: 150px; border:solid white 1.0pt;border-left:none;  background:silver;">
                <p><?= $oooo;?></b>
                </p>
            </td>
        </tr>
        <tr id="logoCaption">
            <td colspan="5">
                <p>
                    <?php echo DENOMINACION_DECENIO;?>
                    <br>
                    <?php echo DENOMINACION_ANIO_1?>
                    <?php echo DENOMINACION_ANIO_2 != '' ? '<br>'.DENOMINACION_ANIO_2 : ''?>
                </p>
            </td>
        </tr>
    </table>
</header>


