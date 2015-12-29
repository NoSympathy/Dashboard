Imports APIControllers

Public Class CharacterTestForm
    Private Sub TextBox1_Click(sender As Object, e As EventArgs) Handles TextBox1.Click
        TextBox1.Text = ""
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Dim apiController = New Character()
        Dim json As String
        json = apiController.GetCharacters(Label2.Text)

        Label2.Text = json
    End Sub
End Class