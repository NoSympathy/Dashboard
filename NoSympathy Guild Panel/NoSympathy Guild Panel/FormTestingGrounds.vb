Imports APIControllers

Public Class FormTestingGrounds

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Dim apiController = New GuildController()
        Dim json As String
        'json = apiController.GetGuildMembers(TextBox1.Text)

        RichTextBox1.Text = json
    End Sub
End Class