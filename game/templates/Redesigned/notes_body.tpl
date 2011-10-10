
<br>
<form action="{PHP_SELF}" method=post>
  <table width=519>
	<tr>
	  <td class=c colspan=4>{Notes}</td>
	</tr>
	<tr>
	  <th colspan=4>
		<div style="margin-left:32px;">
			<a id="newNote" class="button188" href="./?page=networkmnotice&a=1"><span>{MakeNewNote}</span></a>
		</div>
	  </th>
	</tr>
	<tr>
	  <td class=c></td>
	  <td class=c>{Date}</td>
	  <td class=c>{Subject}</td>
	  <td class=c>{Size}</td>
	</tr>

	{BODY_LIST}

<tr>
	  <td colspan=4><input value="{Delete}" type="submit"></td>
	</tr>
  </table>
</form>
</center>
</body>
</html>
