Imports System.Net
Imports Newtonsoft.Json

Public Class Form2

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Dim client = New WebClient()
        Dim endpoints = New Uri("https://api.guildwars2.com/v2/account" + "?access_token=" + TextBox1.Text)

        Dim jsonString = client.DownloadString(endpoints)
        Dim account = JsonConvert.DeserializeObject(Of Account)(jsonString)

        Label1.Text = account.Name
        Label2.Text = account.Id
        Label3.Text = account.World
        ListBox1.DataSource = account.Guilds
        Label5.Text = account.Created
        Label6.Text = account.Access

        client.Dispose()
        RichTextBox1.Text = jsonString
    End Sub

    Public Class Account
        Public Id As String
        Public Name As String
        Public World As String
        Public Guilds As List(Of String)
        Public Created As String
        Public Access As String

    End Class

    Public Class VideoList
        Public Videos As List(Of Video)
    End Class

    Public Class Video
        Public Id As String
        Public Snippet As Snippet
        Public Statistics As Statistic
    End Class

    Public Class Snippet
        Public ChannelId As String
        Public Title As String
        Public CategoryId As String
    End Class

    Public Class Statistic

    End Class
End Class