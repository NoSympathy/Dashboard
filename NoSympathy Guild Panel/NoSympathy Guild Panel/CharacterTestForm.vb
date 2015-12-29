Imports Models
Imports Newtonsoft.Json

Public Class CharacterTestForm
    Private Sub TextBox1_Click(sender As Object, e As EventArgs) Handles TextBox1.Click
        TextBox1.Text = ""
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Dim apiControllers = New APIControllers.Character()
        Dim json As String
        json = apiControllers.GetCharacters(TextBox1.Text)

        Dim Characters = JsonConvert.DeserializeObject(Of List(Of Character))(json)

        'CharacterBindingSource.DataSource = Characters
        DataGridView1.DataSource = Characters
        RichTextBox1.Text = json

    End Sub

    Private Sub LinkLabel1_LinkClicked(sender As Object, e As LinkLabelLinkClickedEventArgs) Handles LinkLabel1.LinkClicked
        Personal_Web.Show()
    End Sub
End Class