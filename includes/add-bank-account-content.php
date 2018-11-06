                            <form method="POST">
                                <table>
                                    <tr>
                                        <td><label for="set-awal">Setoran Awal</label></td><td><input type="text" value="<?=@$_POST['set-awal']?>" name="set-awal" id="set-awal"></td>
                                    </tr>
                                    <tr>
                                        <td></td><td><span class="pesan-error"><?=@$pesan_error['set-awal']?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td><td><input type="submit" value="Tambah"><input type="reset" value="Batal" onclick="location.href='user-management?nama-pengguna=<?=$_GET['nama-pengguna']?>'"></td>
                                    </tr>
                                </table>
                            </form>